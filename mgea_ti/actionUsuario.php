<!-- Inclui o header.php -->
<?php include "header.php" ?>

    <?php
    
        //Verifica o método de requisição do servidor
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Define o bloco de variáveis para armazenar as informações recebidas do formulário
            $fotoUsuario = $nomeUsuario = $dataNascimentoUsuario = $setorUsuario = $emailUsuario = $senhaUsuario = $confirmarSenhaUsuario = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Validação do campo nomeUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["nomeUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Filtra e Armazena o valor na variável
                $nomeUsuario = filtrar_entrada($_POST["nomeUsuario"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $nomeUsuario)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong>
                    deve conter APENAS LETRAS!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo dataNascimentoUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["dataNascimentoUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Filtra e Armazena o valor na variável
                $dataNascimentoUsuario = filtrar_entrada($_POST["dataNascimentoUsuario"]);

                //Usa a função srtlen() para verificar o comprimento da string dataNascimentoUsuario
                if(strlen($dataNascimentoUsuario) == 10){
                    //Aplicar a função substr() para gerar substrings e armazenar dia, mês e ano de nascimento
                    $diaNascimentoUsuario = substr($dataNascimentoUsuario, 8, 2);
                    $mesNascimentoUsuario = substr($dataNascimentoUsuario, 5, 2);
                    $anoNascimentoUsuario = substr($dataNascimentoUsuario, 0, 4);

                    //Usa a função checkdate() para verificar se a data é válida
                    if(!checkdate($mesNascimentoUsuario, $diaNascimentoUsuario, $anoNascimentoUsuario)){
                        echo "<div class='alert alert-warning text-center'><strong>DATA INVÁLIDA!</strong></div>";
                        $erroPreenchimento = true;
                    }

                }
                else{
                    echo "<div class='alert alert-warning text-center'><strong>DATA INVÁLIDA!</strong></div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo setorUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["setorUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>SETOR</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Filtra e Armazena o valor na variável
                $setorUsuario = filtrar_entrada($_POST["setorUsuario"]);
            }

            //Validação do campo emailUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["emailUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Armazena valor do formulário na variável
                $emailUsuario = filtrar_entrada($_POST["emailUsuario"]);
                //Verificar se o email já está cadastrado na base de dados
                include "conexaoBD.php";

                $verificarEmail = "SELECT emailUsuario FROM Usuarios WHERE emailUsuario LIKE '$emailUsuario' ";

                $res = mysqli_query($conn, $verificarEmail) or die("Erro ao tentar verificar o email!");

                $totalEmailsCadastrados = mysqli_num_rows($res);
                if($totalEmailsCadastrados > 0){
                    echo "<div class='alert alert-warning text-center'>O email <strong>$emailUsuario</strong> já foi cadastrado anteriormente no sistema!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo senhaUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["senhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Filtra e Armazena o valor na variável || Aplica a função md5 para criptografar a senha
                $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
            }

            //Validação do campo confirmarSenhaUsuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["confirmarSenhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Filtra e Armazena o valor na variável || Aplica a função md5 para criptografar a senha
                $confirmarSenhaUsuario = md5(filtrar_entrada($_POST["confirmarSenhaUsuario"]));

                //Compara se as senhas são diferentes
                if($senhaUsuario != $confirmarSenhaUsuario){
                    echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas são diferentes!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Início da validação da fotoUsuario
            $diretorio    = "assets/img/"; //Define para qual diretório as imagens serão movidas
            $fotoUsuario  = $diretorio . basename($_FILES['fotoUsuario']['name']); //Montar o nome a ser salvo no BD
            $tipoDaImagem = strtolower(pathinfo($fotoUsuario, PATHINFO_EXTENSION)); //Pega o tipo do arquivo em letras minúsculas
            $erroUpload   = false; //Variável para controle de erros do upload da foto

            //Verifica se o tamanho do arquivo é diferente de ZERO
            if($_FILES["fotoUsuario"]["size"] != 0){

                //Verifica se o tamanho do arquivo é maior do que 5 MegaBytes(MB) - Medida em bytes
                if($_FILES["fotoUsuario"]["size"] > 5000000){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>FOTO</strong> deve ter tamanho máximo de 5MB!</div>";
                    $erroUpload = true;
                }

                //Verifica se a foto está nos formatos JPG, JPEG, PNG ou WEBP
                if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve estar no formatos JPG, JPEG, PNG ou WEBP!</div>";
                    $erroUpload = true;
                }

                //Verifica se a imagem foi movida para o diretório (assets/img), utilizando a função move_uploaded_file()
                if(!move_uploaded_file($_FILES["fotoUsuario"]["tmp_name"], $fotoUsuario)){
                    echo "<div class='alert alert-warning text-center'>Erro ao tentar mover a <strong>FOTO</strong> para o diretório $diretorio!</div>";
                    $erroUpload = true;
                }

            }
            else{
                echo "<div class='alert alert-warning text-center'>O campo <strong>FOTO</strong> é obrigatório!</div>";
                $erroUpload = true;
            }

            //Se NÃO houver erro de preenchimento e NÃO houver erro no upload da foto
            if(!$erroPreenchimento && !$erroUpload){

                //Determina o nível do usuário: 'ti' se setor for TI, caso contrário 'usuario'
                $nivelUsuario = (strtoupper($setorUsuario) == 'TI') ? 'ti' : 'usuario';

                //Criar uma variável para armazenar a QUERY que realiza a inserção de dados do Usuário na tabela Usuarios
                $inserirUsuario = "INSERT INTO Usuarios (fotoUsuario, nomeUsuario, dataNascimentoUsuario, setorUsuario, emailUsuario, senhaUsuario, nivelUsuario)
                                    VALUES ('$fotoUsuario', '$nomeUsuario', '$dataNascimentoUsuario', '$setorUsuario', '$emailUsuario', '$senhaUsuario', '$nivelUsuario')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Se conseguir executar a QUERY para inserção, exibe alerta de sucesso e a tabela com os dados informados
                //A funçao mysqli_query executa operações no Banco de Dados
                if(mysqli_query($conn, $inserirUsuario)){

                    echo "<div class='container'>";
                        echo "<div class='alert alert-success text-center'><strong>USUÁRIO</strong> cadastrado com sucesso!</div>";
                        echo "
                            <div class='container mt-3'>
                                <div class='container mt-3 mb-3 text-center'>
                                    <img src='$fotoUsuario' style='width:150px' title='Foto de $nomeUsuario' class='img-thumbnail'>
                                </div>
                                <table class='table'>
                                    <tr>
                                        <th>NOME</th>
                                        <td>$nomeUsuario</td>
                                    </tr>
                                    <tr>
                                        <th>DATA DE NASCIMENTO</th>
                                        <td>$diaNascimentoUsuario/$mesNascimentoUsuario/$anoNascimentoUsuario</td>
                                    </tr>
                                    <tr>
                                        <th>SETOR</th>
                                        <td>$setorUsuario</td>
                                    </tr>
                                    <tr>
                                        <th>EMAIL</th>
                                        <td>$emailUsuario</td>
                                    </tr>
                                </table>
                                <div class='text-center mb-5'>
                                    <a href='formLogin.php' class='btn btn-outline-dark'>
                                        <i class='bi bi-box-arrow-in-right me-1'></i>
                                        Acessar o Sistema
                                    </a>
                                </div>
                            </div>
                        ";
                    echo "</div>";
                }
                else{
                    echo "<div class='alert alert-danger text-center'>
                    Erro ao tentar inserir dados do <strong>USUÁRIO</strong> no banco de dados $database!</div>";
                }
            }

        }
        else{
            //Usa a função "header()" para redirecionar o usuário para o formUsuario.php
            header("location:formUsuario.php");
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
