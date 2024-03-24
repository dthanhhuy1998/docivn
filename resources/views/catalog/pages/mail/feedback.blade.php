<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    body {
        margin: 0;
        background-color: #ccc;
    }
    table {
        border-spacing: 0;
    }
    td {
        padding: 0;
    }
    img {
        border: 0;
    }
    .wrapper {
        width: 100%;
        table-layout: fixed;
        background-color: #ccc;
        padding-bottom: 60px;
    }
    .main {
        background-color: #fff;
        margin: 0 auto;
        width: 100%;
        max-width: 600px;
        border-spacing: 0;
        font-family: sans-serif;
        color: #4a4a4a;
    }
</style>
<body>
    <center class="wrapper">
        <table class="main" width="100%">
            <tr>
                <td height="8" style="background-color: #E34133;"></td>
            </tr>
            <tr>
                <td>
                    <table width="100%">
                        <p style="font-size: 20px; font-weight: bold; text-align: center;">THÔNG TIN PHIẾU <strong style="color: #E34133;">ĐÓNG GÓP Ý KIẾN</strong></p>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                   <table width="100%" style="padding: 10px; font-size: 14px;">
                        <tr>
                            <td style="padding: 8px; border-right: 1px solid #979A9A; border-top: 1px solid #979A9A; border-bottom: 1px solid #979A9A; border-left: 1px solid#979A9A;">Họ và tên</td>
                            <td style="padding: 8px; border-right: 1px solid #979A9A; border-top: 1px solid #979A9A; border-bottom: 1px solid #979A9A;">{{ $name }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border-right: 1px solid #979A9A; border-bottom: 1px solid #979A9A; border-left: 1px solid#979A9A;">Số điện thoại</td>
                            <td style="padding: 8px; border-right: 1px solid #979A9A; border-bottom: 1px solid #979A9A;">{{ $phoneNumber }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; border-right: 1px solid #979A9A; border-bottom: 1px solid #979A9A; border-left: 1px solid#979A9A;">Nội dung</td>
                            <td style="padding: 8px; border-right: 1px solid #979A9A; border-bottom: 1px solid #979A9A;">{{ $content }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>