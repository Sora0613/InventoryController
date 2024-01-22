<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            color: #333333;
        }

        p {
            color: #666666;
        }

        .cta-buttons {
            margin-top: 20px;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .accept-button {
            background-color: #3490dc;
        }

        .decline-button {
            background-color: #e3342f;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>{{ $inviterName }}さんからの招待</h2>
    <p>{{ $inviterName }}さんからSmart Pantryの在庫リストへの参加招待が届いています！以下のリンクから招待を受けることができます。</p>
    <div class="cta-buttons">
        <a href="{{ $invitationLink }}" class="cta-button accept-button">参加</a>
    </div>
</div>
</body>
</html>
