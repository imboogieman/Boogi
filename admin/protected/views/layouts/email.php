<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width" />
    <style>
        body, table, h1, h2, h3, h4, h5, h6, p, td {
            color: #222222;
            font-family: "Helvetica", "Arial", sans-serif;
            font-weight: normal;
            padding: 0;
            margin: 0;
            line-height: 1.3;
        }
        p {
            margin-bottom: 10px;
        }
        div, p, span, strong, b, em, i, a, li, td {
            -webkit-text-size-adjust: none;
        }
    </style>
</head>
<body>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
        <tr>
            <td align="center" style="background-color: #EEEEEE;">
                <table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse; margin: 20px 0; border-radius: 3px;">
                    <tr>
                        <td align="center" style="background-color: #00b1e4; padding: 10px; border-top-left-radius: 3px; border-top-right-radius: 3px;">
                            <table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td width="200">
                                        <div style="margin: 0; padding: 0; line-height: 15px;">
                                            <a href="<?php echo $this->getBaseUrl(); ?>" target="_blank">
                                                <img src="<?php echo $this->getBaseUrl(); ?>/images/logo-white.png" border="0" width="201" height="57" style="display: block;" alt="Starway" />
                                            </a>
                                        </div>
                                    </td>
                                    <td align="right">
                                        <a href="<?php echo $this->getBaseUrl(); ?>/contact" target="_blank" style="color: #FFFFFF !important; text-decoration: underline;">
                                            <span style="color: #FFFFFF;">Contact Us</span></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="background-color: #FFFFFF; padding: 30px;">
                            <?php echo $content; ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="background: #FFFFFF; border-top: 1px solid #CCCCCC; padding: 15px; font-size: 14px; line-height: 16px; border-bottom-left-radius: 3px; border-bottom-right-radius: 3px;">
                            <table width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
                                <tr>
                                    <td align="center">
                                        Copyright &copy; 2014 by Starway. All Rights Reserved.
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <a href="<?php echo $this->getBaseUrl(); ?>/about" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;">
                                            <span style="color: #00b1e4;">About</span></a>
                                        <a href="<?php echo $this->getBaseUrl(); ?>/terms" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;">
                                            <span style="color: #00b1e4;">T&C</span></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
