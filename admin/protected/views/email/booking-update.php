<table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
    <tr>
        <td align="left">
            <h1>Hey, <?php echo $promoter; ?></h1>
        </td>
    </tr>
    <tr>
        <td align="left" style="border-collapse: collapse; padding: 10px 0;">
            <span style="font-size: 18px; line-height: 21px;">
                <p>
                    There is an updated on your booking request for
                    <a href="<?php echo $this->getBaseUrl() . $link; ?>" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;"><span style="color: #00b1e4;"><?php echo $gig; ?> on <?php echo $date; ?> (click to see)</span></a>
                </p>
            </span>
        </td>
    </tr>
</table>