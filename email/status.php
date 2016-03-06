<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="http://fonts.googleapis.com/css?family=Raleway:600,700,400" rel="stylesheet" type="text/css">
</head>
<body style="margin: 0; padding: 0; color: #414d5f; font-family: 'Raleway', Helvetica, Arial, sans-serif; font-size: 12px; letter-spacing:.5px; font-weight: 400; text-align: center;">

<!--  header  -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#fef6e7" style="background-image:url('cid:header.jpg'); background-size: cover; background-position: center center; background-repeat: no-repeat; background-color:#fef6e7;">
    <tr>
        <td width="40">&nbsp;</td>
        <td>
            <table width="100%">
                <tr>
                    <td width="100%" height="80">&nbsp;</td>
                </tr>
                <tr>
                    <td width="100%" style="font-size: 34px; font-weight: 700; text-transform: uppercase; line-height:50px; letter-spacing:1px; color: #222;">
                        Domain Status
                    </td>
                </tr>
                <tr>
                    <td width="100%" height="80">&nbsp;</td>
                </tr>
            </table>
        </td>
        <td width="40">&nbsp;</td>
    </tr>
</table>
<!--  end header  -->

<!--  content  -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#fbfbfb">

    <tr>
        <!--  spacing  -->
        <td width="100%" height="80">&nbsp;</td>
    </tr>

    <!--  section title  -->
    <tr>
        <td style="font-size: 20px; font-weight: 700;">
            Below are the results of the tests performed on your domains
        </td>
    </tr>
    <!--  end section title  -->

    <tr>
        <!--  spacing  -->
        <td width="100%" height="40">&nbsp;</td>
    </tr>

    <!--  table  -->
    <tr>
        <td width="100%">
            <table width="100%">
                <td width="40">&nbsp;</td>
                <td>

                    <?php
                        $oneMonth = new DateTime();
                        $oneMonth->modify('+1 month');

                        $oneWeek = new DateTime();
                        $oneWeek->modify('+1 week');
                    ?>

                    <table width="100%" cellpadding="10" style="border-collapse: collapse;">
                        <thead style="font-weight: bold; background: #333; color: white;">
                            <td>Domain</td>
                            <td>Domain Expiry</td>
                            <td>Certificate Expiry</td>
                            <td>Safe Browsing</td>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $fqdn => $result) : ?>
                                <tr style="border-bottom: 1px solid #666;">
                                    <td><?php echo $fqdn; ?></td>
                                    <?php if (is_object($result->domainExpiry)) : ?>
                                        <td style="background: <?php echo ($result->domainExpiry < $oneWeek ? 'red' : ($result->domainExpiry < $oneMonth ? 'orange' : 'transparent')); ?>"><?php echo $result->domainExpiry->format('jS M Y'); ?></td>
                                    <?php else : ?>
                                        <td><?php echo $result->domainExpiry; ?></td>
                                    <?php endif; ?>
                                    <?php if (is_object($result->certificateExpiry)) : ?>
                                        <td style="background: <?php echo ($result->certificateExpiry < $oneWeek ? 'red' : ($result->certificateExpiry < $oneMonth ? 'orange' : 'transparent')); ?>"><?php echo $result->certificateExpiry->format('jS M Y'); ?></td>
                                    <?php else : ?>
                                        <td><?php echo $result->certificateExpiry; ?></td>
                                    <?php endif; ?>
                                    <?php if ($result->safeBrowsingResult->issue) : ?>
                                        <?php
                                            $safeBrowsing = [];
                                            if ($result->safeBrowsingResult->malware) $safeBrowsing[] = 'malware';
                                            if ($result->safeBrowsingResult->phishing) $safeBrowsing[] = 'phishing';
                                            if ($result->safeBrowsingResult->unwanted) $safeBrowsing[] = 'unwanted';
                                        ?>
                                        <td style="background: red;"><?php echo implode(' / ', $safeBrowsing); ?></td>
                                    <?php else : ?>
                                        <td>Passed</td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </td>
                <td width="40">&nbsp;</td>
            </table>
        </td>
    </tr>
    <!--  end table  -->

    <tr>
        <!--  spacing  -->
        <td width="100%" height="80">&nbsp;</td>
    </tr>

</table>
<!--  end content  -->

<!--  footer  -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f5f5f5">
    <tr>
        <!--  spacing  -->
        <td width="100%" height="40">&nbsp;</td>
    </tr>
    <tr>
        <td>
            Domain status by <a href="https://joelvardy.com" target="_blank" style="color: #414d5f; font-weight: 600; text-decoration:none;">Joel Vardy</a>.
        </td>
    </tr>
    <tr>
        <!--  spacing  -->
        <td width="100%" height="40">&nbsp;</td>
    </tr>
</table>
<!--  end footer  -->

</body>
</html>
