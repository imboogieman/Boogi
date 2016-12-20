<table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
    <tr>
        <td align="left">
            <h1>Hey, <?php echo $name; ?></h1>
        </td>
    </tr>
    <tr>
        <td align="left" style="border-collapse: collapse; padding: 10px 0;font-size: 18px; line-height: 21px;">
            <p>
                Pupupidu!<br />
                We wanna be loved by you!
            </p>
            <p>
                This mail is to confirm your registration at
                <a href="<?php echo $this->getBaseUrl(); ?>" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;">Boogi.co</a>
                as a promoter:
            </p>
            <p><?php echo $name; ?></p>
            <p>Email: <?php echo $address; ?></p>
            <p>Password: ************</p>
        </td>
    </tr>
</table>