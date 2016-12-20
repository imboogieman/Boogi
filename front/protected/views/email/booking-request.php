<table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
    <tr>
        <td align="left">
            <h1>Hey, <?php echo $name; ?></h1>
        </td>
    </tr>
    <tr>
        <td align="left" style="border-collapse: collapse; padding: 10px 0; vertical-align: top;">
            <span style="font-size: 18px; line-height: 21px;">
                <p>
                    This mail is to confirm that you have just sent a booking with the following details:
                </p>
                <p>
                    <?php echo $artist; ?><br />
                    <?php echo $date; ?><br />
                    <?php echo $venue; ?> (<?php echo $capacity; ?>ppl)<br />
                    <?php echo $city; ?>, <?php echo $country; ?><br />
                    <?php echo $gig_type; ?><br />
                    From <?php echo $set_start; ?> to <?php echo $set_end; ?><br />
                    For <?php echo $price; ?><?php echo $currency; ?><br />
                    Accommodation provided: <?php echo $accommodation; ?><br />
                    Transportation provided: <?php echo $transfer; ?><br />
                </p>
            </span>
        </td>
    </tr>
</table>