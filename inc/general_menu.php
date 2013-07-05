<section id="global_menu_container" class="menu_container">
  <nav id="global_nav">
      <h1 id="main_title" class="out_of_the_way">Menu general pour les sites de musique libre !</h1>
      <ul id="global_menu" class="global_menu">
          <li class="global_menu_list">
              <a href="http://dogmazic.net" class="global_menu_link">dogmazic.net</a>
          </li>
          <li class="global_menu_list">
              <a href="http://musique-libre.org" class="menu_more global_menu_link">Blog</a><button class="menu_more_button button_thick" type="button">+</button>
              <nav class="sub_menu_container">
                  <h1>Derniers articles :</h1>
                  <?php
                    require_once('rsslib.php');
                    echo  rss_reader('http://musique-libre.org/?feed=rss2', 4);
                   ?>
              </nav>
          </li>
          <li class="global_menu_list">
              <a href="http://musique-libre.org/forum" class="global_menu_link menu_more">Forum</a><!--button class="menu_more_button button_thick" type="button">+</button>
              <nav class="sub_menu_container" id="menu_forum">
                  <h1>Derniers messages :</h1>
                  <?php
                    require_once('rsslib.php');
                    echo  rss_reader('http://musique-libre.org/forum/index.php?p=/discussions/feed.rss', 5);
                   ?>
              </nav-->
          </li>
          <li class="global_menu_list">
                <a href="https://github.com/MusiqueLibre/Dogmazic" target="_blank" class="global_menu_link">Github <img alt="lien externe" src="../global_statics/images/ex_link.png" /></a>
          </li>
          <li class="global_menu_list">
              <a href="http://musique-libre.org" class="menu_more global_menu_link">Soutenir</a><button class="menu_more_button button_thick" type="button">+</button>

              <section class="sub_menu_container">
                  <h1>Faire un don</h1>
                  <ul class="global_sub_menu">
                   <li class="global_menu_list">
                      <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="business" value="support@dogmazic.net">
                        <input type="hidden" name="lc" value="FR">
                        <input type="hidden" name="item_name" value="Association Musique Libre">
                        <input type="hidden" name="no_note" value="0">
                        <input type="hidden" name="currency_code" value="EUR">
                        <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
                        <input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">
                        <img alt="" border="0" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
                        <a class="FlattrButton" style="display:none;" href="http://dogmazic.net/"></a>
                        <noscript><a href="http://flattr.com/thing/150302/Help-us-free-the-music" target="_blank">
                        <img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" /></a></noscript> 
                      </form>
                    </li>
                  </ul>
              </section>
          </li>
          <li class="global_menu_list">
            <a href="http://en.irc2go.com/webchat/?net=freenode&room=dogmazic" target="_blank" class="global_menu_link menu_more" id="global_menu_irc">Chat <img alt="lien externe" src="../global_statics/images/ex_link.png" /></a><button class="menu_more_button button_thick" type="button">+</button>
              <section class="sub_menu_container" id="menu_forum">
                 <h1>Discuter en direct :</h1>
                 IRC, ou Instant Relay Chat, est un outil largement utilisé par la communauté libre. Pour vous iy connecter il vous faut un client IRC (irssi, xchat, smuxi...). Le lien du menu vous permet d'accéder à un client en ligne.
                 <br/><br/>
                 L'équipe, les membres, et les curieux de l'assos "Musique Libre !" sont présent sur <b>irc.freenode.net</b>, salon <b>#dogmazic</b>
              </section>
          </li>
          <li class="global_menu_list">
              <a href="http://musique-libre.org/?page_id=285" class="global_menu_link" id="global_menu_contact">Contact</a>
          </li>
      </ul>
  </nav>
  <div class="global_menu_list" id="connection_menu">
      <?php
      if(array_key_exists('sso_authent_mlo',$_COOKIE)){
        echo '<button id="deconnection_button"  >deconnexion</button>';
      }else{
        echo '<a  href="http://musique-libre.org/user" class="buttonified">inscription</a>
         <button id="connection_button" >connexion</button>';

      }
      ?>
      <div id="login_container" class="sub_menu_container"></div>
  </div>
</section>
