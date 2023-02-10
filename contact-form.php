<?php 
    // initialize errors variable
    $errors = "";

    // connect to database
    $db = mysqli_connect("localhost", "root", "root", "contact");

    // insert a quote if submit button is clicked
    if (isset($_POST['submit'])) {
        if (empty($_POST['task'])) {
            $errors = "You must fill in the task";
        }else{
            $task = $_POST['task'];
            $sql = "INSERT INTO contact_form_info (Contact) VALUES ('$task')";
            mysqli_query($db, $sql);
            header('location: contact-form.php');
        }
    }   






?>
<html>
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


<style>
#loading-img{
display:none;
}
.response_msg{
margin-top:10px;
font-size:13px;
background:#E5D669;
color:#ffffff;
width:250px;
padding:3px;
display:none;
}




</style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-8">
<h1>Easy Contact Form With PHP MySQL</h1>
<form name="contact-form" action="" method="post" id="contact-form">
<div class="form-group">
<label for="Name">Name</label>
<input type="text" class="form-control" name="your_name" placeholder="Name" required>
</div>
<div class="form-group">
<label for="exampleInputEmail1">Email address</label>
<input type="email" class="form-control" name="your_email" placeholder="Email" required>
</div>
<div class="form-group">
<label for="Phone">Phone</label>
<input type="text" class="form-control" name="your_phone" placeholder="Phone" required>
</div>
<div class="form-group">
<label for="comments">Comments</label>
<textarea name="comments" class="form-control" rows="3" cols="28" rows="5" placeholder="Comments"></textarea> 
</div>


 
 <div>
  captcha
    <input >

  <div>
  <canvas id="captcha"  style="border:1px solid #000000; background: #f4f4f4;" />
  </div>
  <div>
     <button id="refresh">refresh</button>
  </div>
</div>
            <script type="text/javascript">
                class Captcha {
  config = {
    width: 140,
    height: 30,
    fillStyle: '#666666',
    textBaseline: 'top',
    textAlign: 'left',
    fontSize: '16px',
    fontFamily: 'Ariel',
    shadowColor: '#dddddd',
  }
  INITIAL_SPACE = 15
  SPACE_FACTOR = 20

  constructor($ele, number) {
    this.$ele = $ele;
    this.number = number + '';
  }

  setNumber(number) {
    this.number = number;
  }
  draw() {
    if (!this.$ele) {
      throw new Error('no element provided');
    }
    const context = this.$ele.getContext('2d');
    const {
      width,
      height,
      fillStyle,
      textBaseline,
      textAlign,
      fontSize,
      fontFamily,
      shadowColor,
    } = this.config;

    this.$ele.width = width;
    this.$ele.height = height;

    context.textBaseline = textBaseline;
    context.textAlign = textAlign;
    context.font = `${fontSize} ${fontFamily}`;
    
    const gradient = context.createLinearGradient(0, 0, width, height);
    gradient.addColorStop(0, "#333333");
    gradient.addColorStop(1, "#74fcff");
    context.fillStyle = gradient
    
    context.shadowColor = shadowColor;
    context.shadowOffsetX = 3;
    context.shadowOffsetY = 3;

    let i = 0
    for (; i < this.number.length; i += 1) {
      context.fillText(this.number.charAt(i), i * this.SPACE_FACTOR + this.INITIAL_SPACE , Math.floor(Math.random()*10));
    }
  }
}



const $refresh = document.querySelector('#refresh');
const $captcha = document.querySelector('#captcha');

let captchaValue = Math.floor(Math.random()*1000000);
const myCaptcha = new Captcha($captcha, captchaValue);

$refresh.addEventListener('click', () => {
  captchaValue = Math.floor(Math.random()*1000000);
  const myCaptcha = new Captcha($captcha, captchaValue);
  myCaptcha.draw();
}, false);



myCaptcha.draw();
     

            </script>


<button type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit_form">Submit</button>

</form>
<div class="response_msg"></div>
</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
$(document).ready(function(){
$("#contact-form").on("submit",function(e){
e.preventDefault();
if($("#contact-form [name='your_name']").val() === '')
{
$("#contact-form [name='your_name']").css("border","1px solid red");
}
else if ($("#contact-form [name='your_email']").val() === '')
{
$("#contact-form [name='your_email']").css("border","1px solid red");
}
else
{
$("#loading-img").css("display","block");
var sendData = $( this ).serialize();
$.ajax({
type: "POST",
url: "get_response.php",
data: sendData,
success: function(data){
$("#loading-img").css("display","none");
$(".response_msg").text(data);
$(".response_msg").slideDown().fadeOut(3000);
$("#contact-form").find("input[type=text], input[type=email], textarea").val("");
}
});
}
});
$("#contact-form input").blur(function(){
var checkValue = $(this).val();
if(checkValue != '')
{
$(this).css("border","1px solid #eeeeee");
}
});
});
</script>

</body>
</html>