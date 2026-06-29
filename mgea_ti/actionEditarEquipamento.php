<!-- Inclui o header.php -->
<?php include "header.php" ?>

    <?php
    
        //Verifica o método de requisição do servidor
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Define o bloco de variáveis para armazenar as informações recebidas do formulário
            $fotoEquipamento = $nomeEquipamento = $tipoEquipamento = $patrimonioEquipamento = $descricaoEquipamento = $statusEquipamento = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;
            $erroUpload        = false;

            if(empty($_POST['idEquipamento'])){
                echo "<div class='alert alert-warning text-center'>O equipamento não foi identificado!</div>";
                $erroPreenchimento = true;
            }
            else{
                $idEquipamento = filtrar_entrada($_POST['idEquipamento']);
            }

            //Verifica a foto atual (caso não envie uma nova)
            if(empty($_POST['fotoAtual'])){
                $fotoAtual = "";
            }
            else{
                $fotoAtual = filtrar_entrada($_POST['fotoAtual']);
            }

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

            //Validação do campo Usuarios_idUsuario
            if(empty($_POST["Usuarios_idUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>USUÁRIO RESPONSÁVEL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $idUsuarioResponsavel = filtrar_entrada($_POST["Usuarios_idUsuario"]);
            }

            //Validação do campo descricaoEquipamento
            if(empty($_POST["descricaoEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $descricaoEquipamento = filtrar_entrada($_POST["descricaoEquipamento"]);
            }

            //Validação do campo statusEquipamento
            if(empty($_POST["statusEquipamento"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>STATUS</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $statusEquipamento = filtrar_entrada($_POST["statusEquipamento"]);
            }

            //Verifica se o tamanho do arquivo é diferente de ZERO
            if($_FILES["fotoEquipamento"]["size"] != 0){

                $diretorio       = "assets/img/";
                $fotoEquipamento = $diretorio . basename($_FILES['fotoEquipamento']['name']);
                $tipoDaImagem    = strtolower(pathinfo($fotoEquipamento, PATHINFO_EXTENSION));

                //Verifica se o tamanho do arquivo é maior do que 5 MegaBytes(MB)
                if($_FILES["fotoEquipamento"]["size"] > 5000000){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>FOTO</strong> deve ter tamanho máximo de 5MB!</div>";
                    $erroUpload = true;
                }

                //Verifica se a foto está nos formatos JPG, JPEG, PNG ou WEBP
                if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve estar no formatos JPG, JPEG, PNG ou WEBP!</div>";
                    $erroUpload = true;
                }

                //Verifica se a imagem foi movida para o diretório (assets/img)
                if(!move_uploaded_file($_FILES["fotoEquipamento"]["tmp_name"], $fotoEquipamento)){
                    echo "<div class='alert alert-warning text-center'>Erro ao tentar mover a <strong>FOTO</strong> para o diretório $diretorio!</div>";
                    $erroUpload = true;
                }

            }
            else{
                //Se nenhuma nova foto for enviada, mantém a foto atual
                $fotoEquipamento = $fotoAtual;
            }

            //Se NÃO houver erro de preenchimento e NÃO houver erro no upload da foto
            if(!$erroPreenchimento && !$erroUpload){

                //Criar uma variável para armazenar a QUERY que realiza a edição de dados do Equipamento
                $editarEquipamento = "
                    UPDATE Equipamentos
                    SET
                        fotoEquipamento        = '$fotoEquipamento',
                        nomeEquipamento        = '$nomeEquipamento',
                        tipoEquipamento        = '$tipoEquipamento',
                        patrimonioEquipamento  = '$patrimonioEquipamento',
                        Usuarios_idUsuario     = '$idUsuarioResponsavel',
                        descricaoEquipamento   = '$descricaoEquipamento',
                        statusEquipamento      = '$statusEquipamento'
                    WHERE idEquipamento = $idEquipamento
                ";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Se conseguir executar a QUERY para edição dos registros, exibe alerta de sucesso e a tabela com os dados informados
                if(mysqli_query($conn, $editarEquipamento)){

                    echo "<div class='container'>";
                        echo "<div class='alert alert-success text-center mt-3'><strong>EQUIPAMENTO</strong> editado com sucesso!</div>";
                        echo "
                            <div class='container mt-3'>
                                <div class='container mt-3 mb-3 text-center'>
                                    <img src='$fotoEquipamento' style='width:150px' title='Foto de $nomeEquipamento' class='img-thumbnail'>
                                </div>
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
                                        <th>STATUS</th>
                                        <td>$statusEquipamento</td>
                                    </tr>
                                </table>

                                <div class='text-center mb-5'>
                                    <a href='visualizarEquipamento.php?idEquipamento=$idEquipamento' class='btn btn-outline-dark'>
                                        <i class='bi bi-eye me-1'></i>
                                        Visualizar Equipamento
                                    </a>
                                </div>
                            </div>
                        ";
                    echo "</div>";
                }
                else{
                    echo "<div class='alert alert-danger text-center'>
                    Erro ao tentar editar dados do <strong>EQUIPAMENTO</strong> no banco de dados $database!</div>" . mysqli_error($conn);
                }
            }

        }
        else{
            //Usa a função "header()" para redirecionar o usuário
            header("location:index.php");
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
