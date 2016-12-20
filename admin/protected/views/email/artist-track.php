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
                    <?php echo $artist; ?>, whom you track, added a new gig
                    <a href="<?php echo $this->getBaseUrl() . $gig_link; ?>" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;"><span style="color: #00b1e4;"><?php echo $gig; ?></span></a>.
                </p>
                <p>
                    <a href="<?php echo $this->getBaseUrl() . $link; ?>" target="_blank" style="color: #00b1e4 !important; text-decoration: underline;"><span style="color: #00b1e4;">Check <?php echo $artist; ?> dates to book or collaborate</span></a>.
                </p>
            </span>
        </td>
    </tr>
</table>