const startCameraButton = document.getElementById('start-camera');
const barcodeValueInput = document.getElementById('JAN');
let stream = null;

startCameraButton.addEventListener('click', () => {
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    if (isMobile) {
        // スマートフォンの場合、写真を撮ってからバーコードをスキャンする処理を実行
        const constraints = {
            video: { facingMode: 'environment' },
            audio: false
        };
        navigator.mediaDevices.getUserMedia(constraints)
            .then(handleSuccessMobile)
            .catch(handleError);
    } else {
        // パソコンの場合、リアルタイムでバーコードのスキャンを行う処理を実行
        const constraints = {
            video: { facingMode: 'environment' },
            audio: false
        };
        navigator.mediaDevices.getUserMedia(constraints)
            .then(handleSuccessPC)
            .catch(handleError);
    }
});

function handleSuccessMobile(stream) {
    const video = document.createElement('video');
    video.srcObject = stream;
    video.setAttribute('autoplay', true);
    document.body.appendChild(video);

    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    video.onloadedmetadata = () => {
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        canvas.toBlob((blob) => {
            detectBarcode(blob);
            stream.getVideoTracks().forEach(track => track.stop());
            video.remove();
        }, 'image/jpeg');
    };
}

function handleSuccessPC(stream) {
    const video = document.createElement('video');
    video.srcObject = stream;
    video.setAttribute('autoplay', true);
    document.body.appendChild(video);

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
                    const barcodeValue = barcode.rawValue;
                    console.log(barcodeValue);
                    barcodeValueInput.value = barcodeValue;
                });
            })
            .catch(err => console.error(err));
        requestAnimationFrame(drawFrame);
    };

    video.addEventListener('play', drawFrame);
}

function handleError(error) {
    console.error('getUserMedia error:', error);
}

function detectBarcode(imageBlob) {
    const barcodeDetector = new BarcodeDetector();
    barcodeDetector.detect(imageBlob)
        .then(barcodes => {
            if (barcodes.length > 0) {
                const barcodeValue = barcodes[0].rawValue;
                console.log(barcodeValue);
                barcodeValueInput.value = barcodeValue;
            } else {
                alert('バーコードが見つかりませんでした。');
            }
        })
        .catch(err => console.error(err));
}
