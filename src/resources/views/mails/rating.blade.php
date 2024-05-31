<!--
     Below is the mininum valid AMP4EMAIL document. Just type away
     here and the AMP Validator will re-check your document on the fly.
-->
<!doctype html>
<html ⚡4email data-css-strict>
<head>
    <meta charset="utf-8" />
    <style amp4email-boilerplate>body{visibility:hidden}</style>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
	<script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
    <title>AMP Email Rating</title>
</head>
<body>
    <p>Please rate our service:</p>
    <form method="post" action-xhr="https://www.youtube.com/results?search_query=amp+email+form" target = "_top">
        <textarea id="review" name="review" placeholder="Enter your review" required></textarea>
        <label for="rating-1">1</label>
        <input type="radio" id="rating-1" name="rating" value="1">
        <label for="rating-2">2</label>
        <input type="radio" id="rating-2" name="rating" value="2">
        <label for="rating-3">3</label>
        <input type="radio" id="rating-3" name="rating" value="3">
        <label for="rating-4">4</label>
        <input type="radio" id="rating-4" name="rating" value="4">
        <label for="rating-5">5</label>
        <input type="radio" id="rating-5" name="rating" value="5">
        <button type="submit">Submit</button>
        <div submit-success>
            <template type="amp-mustache">
                <p>Thanks for your rating!</p>
            </template>
        </div>
        <div submit-error>
            <template type="amp-mustache">
                <p>Something went wrong. Please try again.</p>
            </template>
        </div>
    </form>
</body>
</html>
