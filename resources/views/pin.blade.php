<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pin Input</title>
    <style>
        .pin-box {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 1px solid black;
            text-align: center;
            font-size: 20px;
            margin-right: 5px;
        }
    </style>
</head>
<body>
<h1>Enter your PIN</h1>
<div id="pin-input">
</div>
<label>
    Number of Boxes:
    <input type="number" id="num-boxes-input" min="1" max="10" value="5">
</label>
<label>
    Box Input Regex:
    <input type="text" id="box-regex-input" value="^[0-9]{0,5}$">
</label>
<button id="disable-secret-mode-btn">Disable secret mode</button>

<script>
    const pinInput = document.getElementById('pin-input');
    const numBoxesInput = document.getElementById('num-boxes-input');
    const boxRegexInput = document.getElementById('box-regex-input');
    const secretMode = true;
    const autoFocus = true;
    const onComplete = () => alert('PIN input complete!');

    function createPinInput() {
        const numBoxes = parseInt(numBoxesInput.value);
        const regex = new RegExp(boxRegexInput.value);

        // Remove existing boxes
        while (pinInput.firstChild) {
            pinInput.removeChild(pinInput.firstChild);
        }

        // Create new boxes
        for (let i = 0; i < numBoxes; i++) {
            const box = document.createElement('input');
            box.type = 'text';
            box.maxLength = 1;
            box.classList.add('pin-box');

            if (autoFocus && i === 0) {
                box.autofocus = true;
            }

            if (secretMode) {
                box.type = 'password';
            }

            box.addEventListener('input', (event) => {
                const { target } = event;
                const { value } = target;

                if (!regex.test(value)) {
                    target.value = '';
                    return;
                }

                if (value) {
                    target.blur();

                    if (i < numBoxes - 1) {
                        const nextBox = pinInput.children[i + 1];
                        nextBox.focus();
                    } else {
                        onComplete();
                    }
                }
            });

            box.addEventListener('paste', (event) => {
                event.preventDefault();
                const pasteData = event.clipboardData.getData('text').replace(/[^0-9]/g, '');
                const { target } = event;

                for (let char of pasteData) {
                    if (!regex.test(char)) {
                        continue;
                    }

                    target.value = char;
                    target.dispatchEvent(new Event('input'));
                }
            });

            pinInput.appendChild(box);
        }
    }

    createPinInput();

    numBoxesInput.addEventListener('input', createPinInput);
    boxRegexInput.addEventListener('input', createPinInput);

    const disableSecretModeBtn = document.getElementById('disable-secret-mode-btn');
    disableSecretModeBtn.addEventListener('click', () => {
        const boxes = document.querySelectorAll('.pin-box');
        boxes.forEach(box => {
            box.type = 'text';
        });
    });
</script>
</body>
</html>
