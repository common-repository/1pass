<div id="onepass-embed"
    data-url="<?php echo $options['url']; ?>"
    data-title="<?php echo urlencode( $options['title'] ); ?>"
    data-unique-identifier="<?php echo $options['unique_identifier']; ?>"
    data-ts="<?php echo $options['ts']; ?>"
    data-publishable-key="<?php echo $options['publishable_key']; ?>"
    data-hash="<?php echo $options['hash']; ?>"
    data-author-name="<?php echo $options['author_name']; ?>">
</div>

<script type="text/javascript">
  (function(){
    var e=document.getElementsByTagName("script")[0],t=document.createElement("script");
    t.type="text/javascript";
    t.async=true;
    t.id="onepass-js";
    t.src="<?php echo onepass_get_onepass_domain(); ?>/assets/onepass.js";
    e.parentNode.insertBefore(t,e)}
  )()
</script>
