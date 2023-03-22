    <?php
    include('../functions.php');

    if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../loginindex.php');
    } 
    ?>

    <!DOCTYPE html>   
    <html lang="en">   
    <head>   
    <meta charset="utf-8">   
    <title>CBE</title>   
    <meta name="description" content="Bootstrap.">  
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">   
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    
    <script src="js/FileSaver.min.js"></script>
    <script src="js/script.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <style type="text/css">

    #overlayer {
    width:100%;
    height:100%;  
    position:fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    z-index:1;
    background:#fcf7f7;
    }


    .preloader p{
        position: absolute;
        top: 10%;
        left: 50%;
        margin-left: -45px;
        width: 120px;
        height: 90px;
        color: rgb(67, 6, 125);
        font-size: 24px;
        z-index: 3;
        text-align:top;
    }
    

    @keyframes loader {
    0% {
        transform: rotate(0deg);
    }
    
    25% {
        transform: rotate(180deg);
    }
    
    50% {
        transform: rotate(180deg);
    }
    
    75% {
        transform: rotate(360deg);
    }
    
    100% {
        transform: rotate(360deg);
    }
    }

    @keyframes loader-inner {
    0% {
        height: 0%;
    }
    
    25% {
        height: 0%;
    }
    
    50% {
        height: 100%;
    }
    
    75% {
        height: 100%;
    }
    
    100% {
        height: 0%;
    }
    }
    img:hover
    {
    margin:0;
    padding:0;
    width:120%;
    height:120%;
    transform: scale(4.5);
    }
    .formatTable td
    {
    width:120px;
    height:120px;
    text-align:center;
    }
    body{
    background-color: whitesmoke;

    }

    </style>
    </head>  
    <body> 

    <!-- <section>
    <div class="preloader">               
    <div id="overlayer"></div>
    <p> <img src="Moving line.gif" alt="processing..." /></p>
    </div>
    </section> -->
    <div class="container">
    <div class="row header" style="text-align:center;color: white;background-image: url('head3.png');">
    <strong> <h5 style="color: black;">CBE ICAM DATA</h5></strong>
    </div>
    <div class="row header" style=" padding-top:10px;">
    <a href="index.php"><button type="button" class="btn btn-primary">Back <span class="bi bi-arrow-return-left"></span></button></a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php if (isset($_SESSION['user'])) : ?>
    <strong><i style="text-align: center; color:peru; "> <a href="index.php"> <?php echo ucfirst($_SESSION['user']['district']); ?>&nbsp;&nbsp;District </a></i></strong>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <h5 style="text-align:center; color:blue">Click on image to download</h5>
    <?php endif ?>
    
    <h5 style="text-align:right; color:blue">Search by PAN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h5>
    </div>
    <div style="overflow-x:auto;">
    <table id="myTable" class="table table-striped  table-bordered table-striped ">  
    <thead>  
    <tr>  
    <th>Image Name</th>  
    <th>Image</th>  
    <th>Create Date</th>  
    <th>Terminal ID</th>    
    <th>Branch Name</th> 
    <th>Districrt Name</th> 
    </tr>  
    </thead>  
    <tbody> 
    <?php 
    $list = $_SESSION['user']['district'];
    $sql= "SELECT DISTRICT_NAME, ATM_NAME, TERMINAL_ID  FROM district GROUP BY TERMINAL_ID";
    if($result = mysqli_query($db, $sql)){
    if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
    $districtlist = $row['DISTRICT_NAME'] ; 
    $terminalid = $row['TERMINAL_ID'];
    $branchname = $row['ATM_NAME'];
    $files = glob("../../resource/$districtlist/*.*");
    //$files = glob("C:/Users/InfinityDev/Desktop/images/*.*");
    foreach ($files as $image) {
    $supported_file = array(
    'gif',  
    'jpg',
    'jpeg', 
    'png'
    ); 

    $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $filename = $image;
    if (file_exists($filename)) {
    $exif = exif_read_data($filename, 0, true);
    }
//     function maskString($image, $maskChar = '*', $unmaskAmount = 4, $maskFromEnd = false): string
// {
//     $maskLength = strlen($image) - $unmaskAmount;
//     return substr_replace($image, str_repeat($maskChar, $maskLength), $maskFromEnd ? -$maskLength : 0, $maskLength);
// }
    // if (in_array($ext, $supported_file)) {
    echo "<tr ><td>";
    echo basename($image);
    echo "</td><td>";
    echo '<img src="'.$image.'" alt="Random Image", width=30px, height=30px />Download';
    echo "</td><td>";
    echo "".date ("F d Y H:i:s.",$exif['FILE']['FileDateTime']);
    echo "</td><td>";
    echo '' . $terminalid. ' ';
    echo "</td><td>";
    echo '' .$branchname. ' ';
    echo "</td><td>";
    echo '' . $districtlist. ' ';
    echo "</td></tr>";

    //} 

    }

    }
    mysqli_free_result($result);
    }
    }
    ?>
    </tbody>  
    <?php

    ?>
    </table>  
      <input type="button" id="btnExport" value="Export" onclick="Export()" />
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
      <script type="text/javascript">
          function Export() {
              html2canvas(document.getElementById('#myTable'), {
                  onrendered: function (canvas) {
                      var data = canvas.toDataURL();
                      var docDefinition = {
                          content: [{
                              image: data,
                              width: 500
                          }]
                      };
                      pdfMake.createPdf(docDefinition).download("report.pdf");
                  }
              });
          }
      </script>
    </div>
    </div>
    <script>
    $(document).ready(function(){
    $('#myTable').dataTable();
    });
    </script>
    <script>
    function saveImage(e, img=e.target){
    let {src, name} = img,
        a = document.createElement("a");
        ext = src.replace(/.*(\.[a-z]{3,4})$/i, '$1');
    name = (name == null || name =='') ? src.replace(/.*\//i, '') : name.toLowerCase().replace(/\s/g, '_') + ext;
    
    a.style = "display: none";
    fetch(src)
    .then(response => response.blob())
    .then(blob=> {
        console.log(blob);
        var blobUrl = window.URL.createObjectURL(blob);
        a.href = blobUrl;
        a.download = name;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(blobUrl);
        a.remove();
    })
    .then(()=>img.className="downloaded");
}
window.addEventListener('load', ()=> {
    let allImages = document.querySelectorAll('img');
    allImages.forEach(img => {
        img.classList.add('save-image-on-click');
        img.insertAdjacentHTML('afterEnd', `<span class="image-download-indicator" style="--src:url(${img.src})"></span>`);
        img.addEventListener('click', saveImage)
    });
});
</script>
    </body>
    </html>  