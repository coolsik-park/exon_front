<style>
    #loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    background: #eee;
    width: 600px;
    max-width: 100%;
    border: 2px solid #212121;
    border-radius: 4px;
  }
   
  #loginform {
    padding-top: 18px;
    text-align: center;
  }
   
  #loginform p {
    padding: 15px 25px;
    font-size: 1.4rem;
    font-weight: bold;
  }
</style>
<div id="loginform">
    <p>Please enter your name to continue!</p>
    <form action="/Samples/chat" method="post">
    <label for="name">Name &mdash;</label>
    <input type="text" name="name" id="name" />
    <input type="submit" name="enter" id="enter" value="Enter" />
    </form>
</div>