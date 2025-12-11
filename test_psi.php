<?php
require_once "Config/Config.php";
require_once "Libraries/Core/Autoload.php";
require_once "Libraries/Core/Load.php";

try {
    // Test database connection
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>Testing PSI Module</h3>";
    
    // Check if tables exist
    $tables = ['tbl_prestamos', 'tbl_psi_salidas', 'tbl_psi_ingresos'];
    foreach($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if($result->rowCount() > 0) {
            echo "✅ Table $table exists<br>";
        } else {
            echo "❌ Table $table missing<br>";
        }
    }
    
    // Test model
    require_once "Models/PsiModel.php";
    $psiModel = new PsiModel();
    
    echo "<br><h4>Testing Model Methods:</h4>";
    
    // Test getFuncionariosPlanta
    try {
        $funcionarios = $psiModel->getFuncionariosPlanta();
        echo "✅ getFuncionariosPlanta: " . count($funcionarios) . " funcionarios found<br>";
    } catch(Exception $e) {
        echo "❌ getFuncionariosPlanta error: " . $e->getMessage() . "<br>";
    }
    
    // Test selectPrestamos
    try {
        $prestamos = $psiModel->selectPrestamos();
        echo "✅ selectPrestamos: " . count($prestamos) . " préstamos found<br>";
    } catch(Exception $e) {
        echo "❌ selectPrestamos error: " . $e->getMessage() . "<br>";
    }
    
    echo "<br><a href='psi'>Go to PSI Module</a>";
    
} catch (Exception $e) {
    echo "❌ Database Error: " . $e->getMessage();
}
?>