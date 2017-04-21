<!-- This is blank -->
<?php echo $this->Html->script('jquery-3.1.1/jquery-3.1.1.min' , array('inline' => true));?>
<script>
    function switch_first(){
       <?php echo $this->Js->request(['controller' => 'Users', 'action' => 'Session_first'], [
            'async' => true,
            'method' => 'post',
            'data' => '{first: false}',
            'dataExpression' => true,
            'success'=> ' 
                         parent.window.location.reload();
                    ',
            'error' => '
                    //alert(JSON.stringify(XMLHttpRequest));
                    alert(errorThrown);
                '
            ]);       
       ?>
    }
</script>
<?php if (isset($this->params['url']['alert'])):?>
    <script>
        alert('<?php echo $this->params['url']['alert']?>');
        <?php 
            echo $this->Js->request(['controller' => 'Users', 'action' => 'Session_first'], [
                'async' => true,
                'method' => 'post',
                'dataExpression' => true,
                'success'=> '                     
                            if(data === "1"){
                                switch_first();
                            }
                        ',
                'error' => '
                        //alert(JSON.stringify(XMLHttpRequest));
                        alert(errorThrown);
                    '
                ]);
        ?>
    </script>            
<?php endif; ?>
    
