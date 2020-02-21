<html>
    <head>
        <style>
            /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 4rem;
                margin-left: 1.2cm;
                margin-right: 1.2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 1.7rem;
                left: 1.3rem;
                right: 1.3rem;
                height: 60px;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0.5rem; 
                left: 0cm; 
                right: 0cm;
                height: 60px;  
                width:100%; 
                text-align: center;
            }

            footer .page:after { 
                content: counter(page);
            }   

            .h3 { 
                font-size: 2.1rem; margin-bottom: 0.5rem; font-family: inherit; line-height: 1.2; color: #F03434; font-weight: bolder; 
            }

            .card{
                position: relative; display: flex; flex-direction: column; min-width: 0; word-wrap: break-word; background-color: #fff;
                background-clip: border-box;  border: 1px solid #c2cfd6; margin-bottom: 1rem; border-color: white;
            }            

            .ecom-widget-sales ul li span{
                color:#536c79 !important; display:block;  width:100%; word-wrap:break-word; font-size: 0.95rem;
            }

            .ecom-widget-sales ul li {
                font-size: 1rem; color:#F03434 !important; font-weight: 800; margin-bottom: 5px;
            }

            .card-body {
                flex: 1 1 auto; padding: 1rem;
            }

            ul{
                list-style: none !important; margin: 0; padding: 0;
            }

            .title{
                font-size: 5rem;  font-family: inherit; line-height: 1.2; color: #F03434;  max-width: 800px; margin: 0 auto; 
                text-align: center;  
            }

        </style>
    </head>
    <body>

    <?php
        echo '<header>
                <img style="float:left;" src="'.realpath('.').'/PNG/logo-iaudisis.png" width="120" /></div>
            </header>';
        echo '<main><br><br><br>
                <h2 class="title">'.$nombre.'</h2>
                <br><br><br>
            </main>
            <div style="page-break-after:always;"></div>';

        foreach($fotos as $f){
            
            echo'<header>
                    <img style="float:left;" src="'.realpath('.').'/PNG/logo-iaudisis.png" width="120" /></div>
                </header>';

            echo'<footer>
                   <p class="page"></p>
                </footer>';

            echo'<main>
                    <h1 class="h3">'.$nombre.'</h1><br><br>
                    <table>
                        <tr>
                            <td>
                                <div class="card">
                                    <img  src="'.$f["respuesta"].'" width="420" height="445">
                                </div>
                            </td>
                            <td>
                                <div class="card">
                                    <div class="card-body ecom-widget-sales" >
                                        <ul>
                                            <li>Usuario: <span>'.$f["Nombres"].'<br><br></span></li>
                                            <li>Fecha Registro: <span>'.date("d-m-Y",strtotime($f["Fecha_Registro"])).'<br><br></span></li>
                                            <li>Local: <span>'.$f["NombreLocal"].'<br><br></span></li>
                                            <li>Pregunta: <span>'.$f["NombrePregunta"].'<br><br></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </main>
                <div style="page-break-after:always;"></div>';
            
        }

    ?>
</body>
</html>
