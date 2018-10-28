<!-- This is blank -->
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
<?php if (isset($this->request->params['url']['alert'])):?>
    <script>
        alert('<?php echo $this->request->params['url']['alert']?>');
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
    
