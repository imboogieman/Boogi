<?php
    $base = Yii::app()->params['baseUrl'];
?>
<div class="container">
    <div id="page">
        <h1>Boogi API docs</h1>

        <h2>Important notes</h2>
        <ul>
            <li>
                This is API is not RESTful API. We are using JSON-Pure paradigm.
                For more info please read <br /> this article
                <a href="https://mmikowski.github.io/json-pure/">https://mmikowski.github.io/json-pure/</a>.
            </li>
            <li>Currently all request params processed as POST values.</li>
            <li>In all cases API must return HTTP code 200, otherwise - we have a big problems.</li>
            <li>
                if you have any questions, please contact me
                <a href="mailto:manti.by@gmail.com">manti.by@gmail.com</a>.
            </li>
        </ul>

        <h2>API response example</h2>
        <div class="code">{
    "result": 200,
    "data": [{}, ...] or {},
    "message": "Text message",
    "errors": [
        {
            "field": "field-id",
            "message": "Validation error message",
        },
        ...
    ]
}</div>

        <h2>API result codes</h2>
        <ul>
            <li><strong>200</strong> - Success</li>
            <li><strong>204</strong> - Empty result list on search or list filter.</li>
            <li><strong>400</strong> - Validation error. Check "errors" field in response.</li>
            <li><strong>401</strong> - Current request require authorization.</li>
            <li><strong>404</strong> - Object not found (not used with lists).</li>
            <li><strong>500</strong> - Unhandled error. Check "errors" field in response.</li>
        </ul>

        <h2>Endpoint specifications</h2>
        <div class="item">
            <div class="url"><a href="<?php echo $base; ?>/api/artist/list">/api/artist/list</a></div>
            <div class="desc">Return artist list ordered by active gigs count</div>
            <div class="params">
                Request params
                <ul>
                    <li><strong>limit</strong> - count of returned records, default 30.</li>
                    <li><strong>offset</strong> - offset from start, default 0.</li>
                    <li><strong>query</strong> - query to filter artists, default not used.</li>
                </ul>
            </div>
            <div class="return">
                <div class="header" data-target="code">Example success response</div>
                <div id="code" class="code hidden">{
    "result": 200,
    "data": [
        {
            "id": "153",
            "image": "https://graph.facebook.com/286222811951/picture",
            "name": "NickCurly",
            "link": "/nick-curly",
            "description": "",
            "gig_count": "19",
            "promoter_count": "3",
            "latitude": null,
            "longitude": null,
            "following": 0
        },
        ...
    ]
}</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $('.header').click(function() {
                var target = $(this).data('target');
                $('#' + target).toggleClass('hidden');
            });
        });
    })(jQuery);
</script>