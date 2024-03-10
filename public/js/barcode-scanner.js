const startCameraButton = document.getElementById('start-camera');
const video = document.getElementById('barcode-scanner');
const barcodeValueInput = document.getElementById('JAN');
let stream = null;

startCameraButton.addEventListener('click', () => {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
        .then(newStream => {
            stream = newStream;
            video.srcObject = stream;
            video.style.display = 'block'; // カメラを表示する
            startCameraButton.style.display = 'none'; // スタートボタンを非表示にする

            const barcodeDetector = new BarcodeDetector();
            const drawFrame = () => {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                barcodeDetector.detect(canvas)
                    .then(barcodes => {
                        barcodes.forEach(barcode => {
                            // バーコードが検出された時の処理
                            const barcodeValue = barcode.rawValue;
                            console.log(barcodeValue)
                            barcodeValueInput.value = barcodeValue;
                            video.style.display = 'none'; // バーコードが検出されたらカメラを非表示にする
                            startCameraButton.style.display = 'block'; // スタートボタンを再表示する
                            stopCamera();
                        });
                    })
                    .catch(err => console.error(err));
                requestAnimationFrame(drawFrame);
            };

            video.addEventListener('play', drawFrame);
        })
        .catch(err => {
            console.error('getUserMedia error:', err);
        });
});

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}
