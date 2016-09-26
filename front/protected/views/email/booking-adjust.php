<table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
    <tr>
        <td align="left" colspan="2">
            <h1>Hey, <?php echo $name; ?></h1>
        </td>
    </tr>
    <tr>
        <td align="left" style="border-collapse: collapse; padding: 10px 10px 10px 0; vertical-align: top;">
            <img src="<?php echo $image; ?>" alt="<?php echo $artist; ?>" width="100" />
        </td>
        <td align="left" style="border-collapse: collapse; padding: 10px 0; vertical-align: top;">
            <span style="font-size: 18px; line-height: 21px;">
                <p>
                    <?php echo $artist; ?> has adjusted your request for <?php echo $gig; ?>.
                </p>
                <p>
                    Check updates in your
                    <a href="<?php echo $this->getBaseUrl(); ?>/promoter/bookings" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;"><span style="color: #00b1e4;">booking panel</span></a>.
                </p>
            </span>
        </td>
    </tr>
</table>