<table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;">
    <tr>
        <td align="left">
            <h1>Hey, <?php echo $name; ?></h1>
        </td>
    </tr>
    <tr>
        <td align="left" style="border-collapse: collapse; padding: 10px 0;">
            <span style="font-size: 18px; line-height: 21px;">
                <p>
                    Following artist<?php if (count($artists) > 1) : ?>s<?php endif; ?> has confirmed a new gigs in your tracked area:
                </p>
                <p>
                    <?php echo implode(', ', $artists); ?>
                </p>
            </span>
        </td>
    </tr>
</table>