<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ↓CDNでbootstrapをプラグイン↓ -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Document</title>
  <style>
    body {
      padding-top: 20px;
      background-color: #f8f9fa;
    }

    /* テーブルの行にマウスが乗ったら、強制的に「薄い青」にする */
    .table-hover tbody tr:hover>* {
      background-color: #d1e7dd !important;
      /* ここを好きな色に変えられます */
      transition: background-color 0.2s;
      /* ふわっと色が変わるアニメーション */
    }
  </style>
</head>

<body class="container mt-4">

  @yield('content')

</body>

</html>
