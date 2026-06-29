<!-- Inclui o header.php -->
<?php include "header.php" ?>

    <?php
    
        //Verifica o método de requisição do servidor
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Define o bloco de variáveis para armazenar as informações recebidas do formulário
            $fotoEquipamento = "assets/img/default.png";
            $nomeEquipamento = $tipoEquipamento = $patrimonioEquipamento = $descricaoEquipamento = $numeroSerieEquipamento = $contaOfficeEquipamento = $dataEquipamento = $horaEquipamento = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Captura a data e a hora do servidor
            $dataEquipamento = date("Y-m-d");
            $horaEquipamento = date("H:i:s");

            //Validação do campo nomeEquipamento
            if(empty($_POST["nomeEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME DO EQUIPAMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $nomeEquipamento = filtrar_entrada($_POST["nomeEquipamento"]);
            }

            //Validação do campo tipoEquipamento
            if(empty($_POST["tipoEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>TIPO DO EQUIPAMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $tipoEquipamento = filtrar_entrada($_POST["tipoEquipamento"]);
            }

            //Validação do campo patrimonioEquipamento
            if(empty($_POST["patrimonioEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>PATRIMÔNIO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $patrimonioEquipamento = filtrar_entrada($_POST["patrimonioEquipamento"]);
            }

            //Validação do campo Usuarios_idUsuario (responsável)
            if(empty($_POST["Usuarios_idUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>USUÁRIO RESPONSÁVEL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $idUsuarioResponsavel = filtrar_entrada($_POST["Usuarios_idUsuario"]);
            }

            //Validação do campo numeroSerieEquipamento
            if(empty($_POST["numeroSerieEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NÚMERO DE SÉRIE</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $numeroSerieEquipamento = filtrar_entrada($_POST["numeroSerieEquipamento"]);
            }

            //Validação do campo contaOfficeEquipamento
            if(empty($_POST["contaOfficeEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CONTA OFFICE</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $contaOfficeEquipamento = filtrar_entrada($_POST["contaOfficeEquipamento"]);
            }

            //Validação do campo descricaoEquipamento
            if(empty($_POST["descricaoEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $descricaoEquipamento = filtrar_entrada($_POST["descricaoEquipamento"]);
            }

            $erroUpload = false;

            //Se NÃO houver erro de preenchimento e NÃO houver erro no upload da foto
            if(!$erroPreenchimento && !$erroUpload){

                //Criar uma variável para armazenar a QUERY que realiza a inserção de dados do Equipamento na tabela Equipamentos
                $inserirEquipamento = "INSERT INTO Equipamentos (Usuarios_idUsuario, fotoEquipamento, nomeEquipamento, tipoEquipamento, patrimonioEquipamento, descricaoEquipamento, numeroSerieEquipamento, contaOfficeEquipamento, dataEquipamento, horaEquipamento, statusEquipamento)
                                        VALUES ('$idUsuarioResponsavel', '$fotoEquipamento', '$nomeEquipamento', '$tipoEquipamento', '$patrimonioEquipamento', '$descricaoEquipamento', '$numeroSerieEquipamento', '$contaOfficeEquipamento', '$dataEquipamento', '$horaEquipamento', 'ativo')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Se conseguir executar a QUERY para inserção, exibe alerta de sucesso e a tabela com os dados informados
                if(mysqli_query($conn, $inserirEquipamento)){

                    echo "<div class='container'>";
                        echo "<div class='alert alert-secondary text-center'>Equipamento cadastrado com sucesso.</div>";
                        echo "
                            <div class='container mt-3'>
                                <table class='table'>
                                    <tr>
                                        <th>NOME</th>
                                        <td>$nomeEquipamento</td>
                                    </tr>
                                    <tr>
                                        <th>TIPO</th>
                                        <td>$tipoEquipamento</td>
                                    </tr>
                                    <tr>
                                        <th>PATRIMÔNIO</th>
                                        <td>$patrimonioEquipamento</td>
                                    </tr>
                                    <tr>
                                        <th>DESCRIÇÃO</th>
                                        <td>$descricaoEquipamento</td>
                                    </tr>
                                    <tr>
                                        <th>NÚMERO DE SÉRIE</th>
                                        <td>$numeroSerieEquipamento</td>
                                    </tr>
                                    <tr>
                                        <th>CONTA OFFICE</th>
                                        <td>$contaOfficeEquipamento</td>
                                    </tr>
                                    <tr>
                                        <th>DATA</th>
                                        <td>$dataEquipamento às $horaEquipamento</td>
                                    </tr>
                                </table>
                            </div>
                        ";
                    echo "</div>";
                }
                else{
                    echo "<div class='alert alert-secondary text-center'>Não rolou cadastrar o equipamento. Dá uma olhada e tenta de novo.</div>" . mysqli_error($conn);
                }
            }

        }
        else{
            //Usa a função "header()" para redirecionar o usuário para o formEquipamento.php
            header("location:formEquipamento.php");
        }

        //Função para filtrar entrada de dados
        function filtrar_entrada($dado){
            $dado = trim($dado); //Remove espaços desnecessários
            $dado = stripslashes($dado); //Remove barras invertidas
            $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

            //Retorna o dado após filtrado
            return($dado);
        }
    
    ?>

<!-- Inclui o footer.php -->
<?php include "footer.php" ?>
