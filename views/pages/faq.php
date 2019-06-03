<?php
include APP_PATH . '/views/includes/head.php';
include APP_PATH . '/views/includes/header.php';
?>
<main class="faq-main">
   <div class="faq-container">
       <h2>Frequently Asked Questions</h2>
       <ul class="accordion">
           <?php foreach($payload as $faq){ $questions = $faq['questions']; $answer = $faq['answers'];?>
           <li>
           <a href="javascript:void(0);" class="toggle"><?=$questions?></a>
           <p class="inner"><?=$answer?></p>
          </li>
           <?php }?>
       </ul>
   </div>
</main>
<script>
    $('.toggle').click(function(e) {
  	e.preventDefault();
  
    var $this = $(this);
  
    if ($this.next().hasClass('show')) {
        $this.next().removeClass('show');
        $this.next().slideUp(350);
    } else {
        $this.parent().parent().find('li .inner').removeClass('show');
        $this.parent().parent().find('li .inner').slideUp(350);
        $this.next().toggleClass('show');
        $this.next().slideToggle(350);
    }
});
</script>
<?php
include APP_PATH . '/views/includes/footer.php';
?>