<style>
    nav > div.list-group > div {
        margin-bottom: 10px;
        cursor: pointer;
    }
    nav > div.list-group > div > div.list-group {
        margin-bottom: 0px !important;
    }
    div.content_container {
        background-size: cover;
    }
    div.content_container .content, nav {
        background-color: rgb(255, 255, 255);
    }
    body{
        background-color: rgb(241, 241, 241);
    }
    <?php if ($this->Session->read('Auth.User')['location'] == 'Palmerston North Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_pn.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Mt Albert Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_pn.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Ruakura Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_ruakura.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Lincoln Research Centre'): ?>
        div.content_container {background-image: url('img/chemlab_pn.jpg');}
    <?php elseif ($this->Session->read('Auth.User')['location'] == 'Otago University'): ?>
        div.content_container {background-image: url('img/chemlab_otago.jpg');}
    <?php else: ?>
        div.content_container {background-image: url('img/palmy_town50scale.jpg');}
    <?php endif; ?>

</style>



<div class="container-fluid content_container"  style="height: 100vh; overflow-y: auto">
    <div class="col-lg-10 col-lg-offset-1 content container layer-2" id="main_content"></div>
</div>