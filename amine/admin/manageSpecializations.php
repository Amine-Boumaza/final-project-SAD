<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Specializations</title>
</head>

<body>
    <h2>Manage Specializations</h2>

    <?php
    // Include your necessary PHP files here
    include '../db_conn.php';  // Assuming db_conn.php includes the database connection

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addSpecialization"])) {
        // Retrieve form data
        $specializationName = mysqli_real_escape_string($conn, $_POST["specializationName"]);
        $maxCapacity = mysqli_real_escape_string($conn, $_POST["maxCapacity"]);
        $specializationGrade = mysqli_real_escape_string($conn, $_POST["specializationGrade"]);
        $branchRestriction = mysqli_real_escape_string($conn, $_POST["branchRestriction"]);
        $determiningModule = mysqli_real_escape_string($conn, $_POST["determiningModule"]);

        // Insert the new specialization into the Specializations table
        $insertSpecializationSQL = "INSERT INTO Specializations (Name, BranchRestriction, DeterminingModuleID, MaxCapacity, SpecializationGrade) 
                                    VALUES ('$specializationName', '$branchRestriction', '$determiningModule', '$maxCapacity', '$specializationGrade')";

        if ($conn->query($insertSpecializationSQL) === TRUE) {
            $successMessage = "New specialization added successfully";
        } else {
            $errorMessage = "Error: " . $insertSpecializationSQL . "<br>" . $conn->error;
        }
    }
    ?>

    <!-- Form to add a new specialization -->
    <form method="post" action="">
        <label for="specializationName">Specialization Name:</label>
        <input type="text" name="specializationName" required><br>

        <label for="maxCapacity">Max Capacity:</label>
        <input type="number" name="maxCapacity" required><br>

        <label for="specializationGrade">Specialization Grade:</label>
        <input type="text" name="specializationGrade" required><br>

        <label for="branchRestriction">Branch Restriction:</label>
        <select name="branchRestriction" id="branchRestriction" required>
            <option value="No Branch">No Branch</option>
            <?php
            // Fetch all branches from the HighSchoolModules table
            $branchesQuery = "SELECT DISTINCT HighSchoolBranch FROM HighSchoolModules";
            $branchesResult = $conn->query($branchesQuery);

            while ($row = $branchesResult->fetch_assoc()) {
                echo "<option value='" . $row['HighSchoolBranch'] . "'>" . $row['HighSchoolBranch'] . "</option>";
            }
            ?>
        </select>

        <button type="button" id="updateModules">Update Modules</button><br>

        <label for="determiningModule">Determining Module:</label>
        <select name="determiningModule" required>
            <option value="">No Determining Module</option>
            <!-- Options will be dynamically populated using JavaScript -->
        </select><br>

        <button type="submit" name="addSpecialization">Add Specialization</button>
    </form>

    <script>
        // Fetch modules based on the selected branch and populate the determining module dropdown
        document.getElementById('updateModules').addEventListener('click', function() {
            var selectedBranch = document.getElementById('branchRestriction').value;
            var determiningModuleDropdown = document.querySelector('select[name="determiningModule"]');

            // Clear previous options
            determiningModuleDropdown.innerHTML = '<option value="">No Determining Module</option>';

            // Fetch modules based on the selected branch
            if (selectedBranch !== "No Branch") {
                var modulesQuery = "SELECT ModuleName FROM HighSchoolModules WHERE HighSchoolBranch = '" + selectedBranch + "'";
                fetchModules(modulesQuery);
            }
        });

        function fetchModules(query) {
            fetch('fetch_modules.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'query=' + encodeURIComponent(query),
                })
                .then(response => response.json())
                .then(data => {
                    var determiningModuleDropdown = document.querySelector('select[name="determiningModule"]');
                    data.forEach(module => {
                        var option = document.createElement('option');
                        option.value = module.ModuleName;
                        option.textContent = module.ModuleName;
                        determiningModuleDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching modules:', error));
        }
    </script>

    <?php
    // Display success or error messages from the PHP code
    if (isset($successMessage)) {
        echo "<p style='color: green;'>$successMessage</p>";
    } elseif (isset($errorMessage)) {
        echo "<p style='color: red;'>$errorMessage</p>";
    }
    ?>

</body>

</html>