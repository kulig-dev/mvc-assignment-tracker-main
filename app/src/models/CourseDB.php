/**
 * CourseDB class represents the data access layer for courses.
 */
class CourseDB {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get all courses.
     *
     * @return array An array of course data.
     * @throws Exception If there is an error during database query execution.
     */
    public function getAllCourses() {
        try {
            $query = "SELECT * FROM courses";
            $result = $this->db->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching courses: " . $e->getMessage());
        }
    }

    /**
     * Get the course name by ID.
     *
     * @param int $courseID The ID of the course.
     * @return string|null The course name or null if not found.
     * @throws Exception If there is an error during database query execution.
     */
    public function getCourseNameByID($courseID) {
        try {
            if (!$courseID) {
                return "All Courses";
            }
            $query = 'SELECT courseName FROM courses WHERE courseID = :courseID';

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            $stmt->execute();
            $courseName = $stmt->fetchColumn();
            return $courseName ? $courseName : null;
        } catch (PDOException $e) {
            throw new Exception("Error fetching course name: " . $e->getMessage());
        }
    }

    /**
     * Add a new course.
     *
     * @param string $courseName The name of the course.
     * @return bool True on success, false on failure.
     * @throws Exception If there is an error during database query execution.
     */
    public function addCourse($courseName) {
        try {
            $query = "INSERT INTO courses (courseName) VALUES (:courseName)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':courseName', $courseName);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error adding course: " . $e->getMessage());
        }
    }

    /**
     * Edit an existing course.
     *
     * @param int $courseID The ID of the course to edit.
     * @param string $newName The new name for the course.
     * @return bool True on success, false on failure.
     * @throws Exception If there is an error during database query execution.
     */
    public function editCourse($courseID, $newName) {
        try {
            $query = "UPDATE courses SET courseName = :newName WHERE courseID = :courseID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':newName', $newName);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error editing course: " . $e->getMessage());
        }
    }

    /**
     * Delete a course by its ID.
     *
     * @param int $courseID The ID of the course to delete.
     * @return bool True on success, false on failure.
     * @throws Exception If there is an error during database query execution.
     */
    public function deleteCourse($courseID) {
        try {
            $query = "DELETE FROM courses WHERE courseID = :courseID";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting course: " . $e->getMessage());
        }
    }
}