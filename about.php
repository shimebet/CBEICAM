<?php
include("index.php")
?>
  
<div class="container">
<style>

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
  margin: 0 auto;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  padding: 50px;
  text-align: center;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  color: black;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}
h2{
  font-family:italic;
}
.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 30%;
}

.button:hover {
  background-color: #555;
}
p{
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
</style>
<h2 style="text-align:center">Commercial Bank of Ethiopia 
Digital Channel Application Management 
</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="images/cbe.jpg" alt="cbe birr" style="width:100%; height: 100px;">
      <div class="container">
        <h2>CBE BIRR</h2>
        <p class="title">CBE BIRR </p>
        <p>CBE Birr is a mobile banking services streamed </p> 
        <p> by Commercial Bank of Ethiopia through banking agents.</p>
        <p>CBE@commercial.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="images/mobile.png" alt="mobile banking" style="width:100%; height: 100px;">
      <div class="container">
        <h2>Mobile Bancking</h2>
        <p class="title">Mobile Bancking</p>
        <p>Can involve communication through USSD, Internet,</p> 
       <p> or an application designed for the bank services.</p>
        <p>Mobile@commercial.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <img src="images/ATM.jpg" alt="ussd" style="width:100%; height: 100px;">
      <div class="container">
        <h2>ATM </h2>
        <p class="title">ATM MACHINE</p>
        <p>The pioneer in introducing ATM to the country With our . </p>
        <p>card, you can bank 24 hours a day and 7 days a week.</p>
        <p>USSD@commercial.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
</div>
<div class="about-section">
  <h1>About ICAM</h1>
  <p style="font-size:20px;">Considering the growth of ATM usage fraud protection to self-service financial terminals is critical. 
    CBE ATMS namely NCR and Diebold has a capability to capture transaction images of customers and store locally 
    on the terminal. The software is web based capable of cutting zipped folder for transaction images from self-serve 
    terminals to on a daily base and make available based on PAN, Date at least. It enables financial institutions to 
    capture, store and manipulate images and videos of ATM customers while they transact. Images are captured on multiple
     events such as Card Insert/Eject, Cash Dispense, Bunch Note Acceptor States, Cheque Processing Module States, Card 
     Capture and Close State. These events are remotely  configurable for the ease and suitability of the financial institutions’ needs.</p>

</div>
</div>





