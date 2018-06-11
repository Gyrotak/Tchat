<?php $title = "T'Chat"; ?>
<?php ob_start(); ?>

<div class="container">
        <div class="row">
       <button onclick="location.href='/Tchat/deconnexion'" class="btn btn-danger" style="margin:auto;margin-bottom:2%;" >Deconnexion</button>
<div class="">
                <div class="panel panel-primary">
                    <div class="panel-heading" id="accordion">
    <span class="glyphicon glyphicon-comment"></span> Chat (connecte en tant que <?= $_SESSION["email"]; ?>)
    <div class="btn-group pull-right">
    <span onclick="location.reload();" class="glyphicon glyphicon-refresh"></span>
    </div>
                    </div>
                <div class="" id="collapseOne">
                    <div class="panel-body">
                        <ul class="chat">
<?php foreach($send["allMessages"] as $message) {
      if ($message["ID_User"] != $_SESSION["id_user"]) {
?>
                            <li class="left clearfix"><span class="chat-img pull-left">
                                <img src="http://placehold.it/50/55C1E7/fff&text=T" alt="User Avatar" class="img-circle" />
                            </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                                       <strong class="primary-font"></strong> <small class="pull-right text-muted">
                                                       <span class="glyphicon glyphicon-time"></span><?= $message['Created_at']; ?></small>
                                    </div>
                                                       <p> <?= $message["Message"]; ?> </p>
                                </div>
                            </li>
<?php } else { ?>
                            <li class="right clearfix"><span class="chat-img pull-right">
                                <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                            </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
               <small class=" text-muted"><span class="glyphicon glyphicon-time"></span><?= $message['Created_at']; ?></small>
                                        <strong class="pull-right primary-font"> <?= $_SESSION["email"]; ?> </strong>
                                    </div>
                                    <p><?= $message["Message"]; ?></p>
                                </div>
                            </li>
<?php } } ?>
                          </ul>
                    </div>
                    <div class="panel-footer">
<form method="post">
                        <div class="input-group">
                            <input id="btn-input" type="text" name="text" class="form-control input-sm" placeholder="Type your message here..." />
                            <span class="input-group-btn">
                                <button class="btn btn-warning btn-sm" id="btn-chat" name="send" type="submit">Send</button>
                            </span>
                        </div>
    </form>
                    </div>
                </div>
                </div>
            </div>
    <div class="list-group">
      <a href="#" class="list-group-item disabled">
        Utilisateur connecte
      </a>
<?php foreach($send["UserConnected"] as $user) { ?>
       <li class="list-group-item"><?= $user["Email"]?></li>
<?php } ?>
    </div>
                 </ul>
               </div>
            </div>
        </div>
    </div>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>