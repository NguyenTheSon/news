
	<nav class="navbar navbar-default">
    <ul class="nav navbar-nav">
        <li class="active"><a href="/">Home<span class="sr-only"></span></a></li>
        <li id="navusers"><?php echo $this->Html->link('User', array('controller' => 'users', 'action' => 'index')); ?></li>
        <li id="navcategories"><?php echo $this->Html->link('Category', array('controller' => 'categories', 'action' => 'index')); ?></li>
        <li id="navproducts"><?php echo $this->Html->link('Product', array('controller' => 'products', 'action' => 'index')); ?></li>
        <li id="navnews"><?php echo $this->Html->link('News', array('controller' => 'News', 'action' => 'index')); ?></li>
        <li id="navpurchases"><?php echo $this->Html->link('Purchase', array('controller' => 'purchases', 'action' => 'index')); ?></li>
        <li id="navreports" class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Report<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
             <li><?php echo $this->Html->link('Comment User', array('controller' => 'reports', 'action' => 'comment_user')); ?></li>
             <li><?php echo $this->Html->link('Comment Product', array('controller' => 'reports', 'action' => 'comment_product')); ?></li>
             <li><?php echo $this->Html->link('Product', array('controller' => 'reports', 'action' => 'product')); ?></li>
          </ul>
        </li>
        <li id="navstats"><?php echo $this->Html->link('Stats', array('controller' => 'stats', 'action' => 'index')); ?></li>
        
     </ul>
</nav>
<script>
$(".navbar").find(".active").removeClass();
$(".navbar #nav<? echo $this->params['controller']; ?>").addClass('active');
</script>
