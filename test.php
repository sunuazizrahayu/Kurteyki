<style>
.cookieConsentContainer {
  z-index: 999;
  width: 450px;
  min-height: 20px;
  box-sizing: border-box;
  padding: 30px 30px 30px 30px;
  background: #232323;
  overflow: hidden;
  position: fixed;
    bottom: 20px;
  right: 20px;
  display: none;
}
.cookieConsentContainer .cookieTitle a {
  font-family: OpenSans, arial, "sans-serif";
  color: #FFFFFF;
  font-size: 22px;
  line-height: 20px;
  display: block;
}
.cookieConsentContainer .cookieDesc p {
  margin: 0;
  padding: 0;
  font-family: OpenSans, arial, "sans-serif";
  color: #FFFFFF;
  font-size: 13px;
  line-height: 20px;
  display: block;
  margin-top: 10px;
} .cookieConsentContainer .cookieDesc a {
  font-family: OpenSans, arial, "sans-serif";
  color: #FFFFFF;
  text-decoration: underline;
}
.cookieConsentContainer .cookieButton a {
  display: inline-block;
  font-family: OpenSans, arial, "sans-serif";
  color: #fff;
  font-size: 14px;
  font-weight: bold;
  margin-top: 14px;
  background: #d24040;
  box-sizing: border-box; 
  padding: 12px 20px;
  text-align: center;
  transition: background 0.3s;
}
.cookieConsentContainer .cookieButton a:hover { 
  cursor: pointer;
  background: #4d8022;
  color: #fff;
}
.link-cookie-policy{
  opacity: .6;
}
.link-cookie-policy:hover {
  opacity: .8;
}

@media (max-width: 980px) {
  .cookieConsentContainer {
    bottom: 0px !important;
    left: 0px !important;
    width: 100%  !important;
  }
}  
</style>

<div class="cookieConsentContainer" id="cookieConsentContainer" style="display: block">
  <!-- <div class="cookieTitle">
    <a>Cookies.</a>
  </div> -->
  <div class="cookieDesc">
    <p>
      This website uses cookies to personalize content and analyse traffic in order to offer you a better experience.      <a class="link-cookie-policy" href="http://localhost/lms/home/cookie_policy">Cookie policy</a>
    </p>
  </div>
  <div class="cookieButton">
    <a onclick="cookieAccept();">Accept</a>
  </div>
</div>
<script>
  $(document).ready(function () {
    if (localStorage.getItem("accept_cookie_kurteyki")) {
      //localStorage.removeItem("accept_cookie_kurteyki");
    }else{
      $('#cookieConsentContainer').fadeIn(1000);
    }
  });

  function cookieAccept() {
    if (typeof(Storage) !== "undefined") {
      localStorage.setItem("accept_cookie_kurteyki", true);
      localStorage.setItem("accept_cookie_time", "05/02/2020");
      $('#cookieConsentContainer').fadeOut(1200);
    }
  }
</script>