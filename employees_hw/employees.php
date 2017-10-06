<?php
// show me my errors pls
ini_set('display_errors', 1);

// db credentials
$servername = "localhost";
$username = "root";
$password = "root";

$query = "SELECT title, first_name, last_name, dept_name, salary
    -- we need a group by and take max salary of each employee to exclude raises
    -- since each emp has more than 1 (salary, from_date) combination
    FROM (
        SELECT emp_no, MAX(salary) as salary, from_date
        FROM salaries
        -- take only active employee records
        WHERE to_date = '9999-01-01'
        GROUP BY emp_no, from_date
    ) AS g
    JOIN employees e ON e.emp_no = g.emp_no
    JOIN current_dept_emp de
        -- ensure that department is in correct salary period
        ON de.emp_no = e.emp_no AND de.from_date = g.from_date
    JOIN departments d ON d.dept_no = de.dept_no
    JOIN titles t 
        -- ensure that title is in correct salary period
        ON t.emp_no = g.emp_no AND g.from_date = g.from_date
    -- take top 5 records
    ORDER BY salary DESC LIMIT 5";

try {
    // open db connection
    $conn = new PDO("mysql:host=$servername;dbname=employees", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully<br />"; 

    // prepary statement query and exectute
    $statement = $conn->prepare($query);
    // make result an associative array
    $statement->setFetchMode(PDO::FETCH_ASSOC);
    $statement->execute();
    $emps = $statement->fetchAll();

    // convert over employee array to json
    $json = json_encode($emps);

    // open a tmp file, write our json, and close it
    $file = fopen("/tmp/employees.json", "w") or die("Unable to open file!");
    fwrite($file, $json);
    fclose($file);
    echo "JSON was dumped!\n";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>