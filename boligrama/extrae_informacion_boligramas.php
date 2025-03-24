<?php
   $files = [
      '1_15_modificado.json'=>'Ingeniería Ambiental',
      '2_14_modificado.json'=>'Ingeniería Civil',
      '3_17_modificado.json'=>'Ingeniería Eléctrica',
      '4_16_modificado.json'=>'Ingeniería Física',
      '5_14_modificado.json'=>'Ingeniería Industrial',
      '6_14_modificado.json'=>'Ingeniería Mecánica',
      '7_14_modificado.json'=>'Ingeniería Metalúrgica',
      '8_12_modificado.json'=>'Ingeniería Química',
      '9_15_modificado.json'=>'Ingeniería Electrónica',
      '122_9_modificado.json'=>'Ingeniería en Computación'
   ];

   $archivo_salida = fopen("estadisticas_propuestos.txt", "w");

   fwrite($archivo_salida, "\\begin{table}[]\n");
   fwrite($archivo_salida, "\\begin{tabular}{|c|c|ccccccccccccc|}\n");
   fwrite($archivo_salida, "\\hline\n");
   fwrite($archivo_salida, "\\multirow{2}{*}{\\textbf{Plan de estudios}} & \\multirow{2}{*}{\\textbf{\\begin{tabular}[c]{@{}c@{}}Número\\\\ de:\\end{tabular}}} & \\multicolumn{13}{c|}{\\textbf{Trimestre}} \\\\ \\cline{3-15} \n");
   fwrite($archivo_salida, " &  & \\multicolumn{1}{c|}{\\textbf{1}} & \\multicolumn{1}{c|}{\\textbf{2}} & \\multicolumn{1}{c|}{\\textbf{3}} & \\multicolumn{1}{c|}{\\textbf{4}} & \\multicolumn{1}{c|}{\\textbf{5}} & \\multicolumn{1}{c|}{\\textbf{6}} & \\multicolumn{1}{c|}{\\textbf{7}} & \\multicolumn{1}{c|}{\\textbf{8}} & \\multicolumn{1}{c|}{\\textbf{9}} & \\multicolumn{1}{c|}{\\textbf{10}} & \\multicolumn{1}{c|}{\\textbf{11}} & \\multicolumn{1}{c|}{\\textbf{12}} & \\textbf{13} \\\\ \\hline\n");
   

   foreach($files as $file => $nombre_plan){
      if(!file_exists($file)){
         echo "Advertencia: El archivo $file no se encontró.\n";
         continue;
      }

      $plan = json_decode(file_get_contents($file), true);
      if(!$plan || !isset($plan['ueas'])){
         echo "Error: No se pudo leer correctamente el archivo $file\n";
         continue;
      }

      $ueas = array_fill(1, 13, 0);
      $creditos = array_fill(1, 13, 0);

      foreach($plan['ueas'] as $uea){
         if(isset($uea['trimestre'], $uea['creditos'])){
            $trimestre = $uea['trimestre'];
            $creditos_uea = $uea['creditos'];

            if($trimestre > 0 && $trimestre <= 13){
               ++$ueas[$trimestre];
               $creditos[$trimestre] += $creditos_uea;
            }
         }
      }

      // Escribir la información en formato LaTeX
      fwrite($archivo_salida, "\\multirow{2}{*}{\\textbf{".$nombre_plan."}} & \\textbf{UEA's} ");
      for($i = 1; $i <= 13; $i++){
         fwrite($archivo_salida, "& \\multicolumn{1}{c|}{{$ueas[$i]}} ");
      }

      fwrite($archivo_salida, "\\\\ \\cline{2-15} \n");
      fwrite($archivo_salida, " & \\textbf{Créditos} ");
      for($i = 1; $i <= 13; $i++){
         fwrite($archivo_salida, "& \\multicolumn{1}{c|}{{$creditos[$i]}} ");
      }
      //fwrite($archivo_salida, "\\\\ \n");
      fwrite($archivo_salida, "\\\\ \\hline\n");
   }

   fwrite($archivo_salida, "\\end{tabular}\n");
   fwrite($archivo_salida, "\\end{table}\n");
   fclose($archivo_salida);

   echo "Tabla generada en estadisticas_propuestos.txt\n";
?>
