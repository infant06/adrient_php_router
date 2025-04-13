<?php
// Required database and function files
require_once '../config/db.php';
require_once '../config/function.php';
require_once 'function.php';

// Set JSON content type header
header('Content-Type: application/json');

// Initialize response array
$response = [];

// Check if request is JSON
$contentType = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';

// Handle both JSON and form data
if (strpos($contentType, 'application/json') !== false) {
    // Parse JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON request']);
        exit;
    }
} else {
    // Use regular POST data
    $data = $_POST;
}

// Get the event type (required)
$event = isset($data['event']) ? $data['event'] : '';

// If no event is specified, return error
if (empty($event)) {
    echo json_encode(['error' => 'No event specified']);
    exit;
}

// Use the existing database connection from db.php
// $conn is already defined in the included db.php file

// Switch based on event type
switch ($event) {
    // Fetch all blogs
    case 'fetch_blogs':
        try {
            // Use fetchBlogsWithCategories instead of get_all_blogs
            $blogs = fetchBlogsWithCategories($conn);
            echo json_encode($blogs);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Post a new blog
    case 'post_blog':
        try {
            $title = isset($data['title']) ? $data['title'] : '';
            $content = isset($data['content']) ? $data['content'] : '';
            $category_id = isset($data['category_id']) ? $data['category_id'] : '';
            $short_description = isset($data['short_description']) ? $data['short_description'] : '';

            // Prepare data array for createBlog function
            $blogData = [
                'title' => $title,
                'content' => $content,
                'category_id' => $category_id,
                'short_description' => $short_description
            ];

            // Handle file upload if present in $_FILES
            $file = isset($_FILES['image']) ? $_FILES : [];

            createBlog($conn, $blogData, $file);

            echo json_encode([
                'success' => true,
                'message' => 'Blog post created successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Update an existing blog
    case 'update_blog':
        try {
            // Prepare data array for updateBlog function
            $blogData = [
                'id' => isset($data['id']) ? $data['id'] : '',
                'title' => isset($data['title']) ? $data['title'] : '',
                'content' => isset($data['content']) ? $data['content'] : '',
                'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                'short_description' => isset($data['short_description']) ? $data['short_description'] : ''
            ];

            // Handle file upload if present in $_FILES
            $file = isset($_FILES['image']) ? $_FILES : [];

            updateBlog($conn, $blogData, $file);

            echo json_encode([
                'success' => true,
                'message' => 'Blog post updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Delete a blog
    case 'delete_blog':
        try {
            $blog_id = isset($data['id']) ? $data['id'] : '';

            if (empty($blog_id)) {
                throw new Exception('Blog ID is required');
            }

            deleteBlog($conn, $blog_id);

            echo json_encode([
                'success' => true,
                'message' => 'Blog post deleted successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Fetch all events
    case 'fetch_events':
        try {
            // Use fetchEventsWithCategories instead of get_all_events
            $events = fetchEventsWithCategories($conn);
            echo json_encode($events);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Post a new event
    case 'post_event':
        try {
            // Prepare data array for createEvent function
            $eventData = [
                'title' => isset($data['title']) ? $data['title'] : '',
                'description' => isset($data['description']) ? $data['description'] : '',
                'event_date' => isset($data['event_date']) ? $data['event_date'] : ''
            ];

            // Handle file upload if present in $_FILES
            $file = isset($_FILES['image']) ? $_FILES : [];

            createEvent($conn, $eventData, $file);

            echo json_encode([
                'success' => true,
                'message' => 'Event created successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Update an existing event
    case 'update_event':
        try {
            $event_id = isset($data['id']) ? $data['id'] : '';

            // Prepare data for updateEvent function
            $eventData = [
                'title' => isset($data['title']) ? $data['title'] : '',
                'description' => isset($data['description']) ? $data['description'] : '',
                'event_date' => isset($data['event_date']) ? $data['event_date'] : ''
            ];

            // Handle file upload if present in $_FILES
            $file = isset($_FILES['image']) ? $_FILES : [];

            updateEvent($conn, $event_id, $eventData, $file);

            echo json_encode([
                'success' => true,
                'message' => 'Event updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Delete an event
    case 'delete_event':
        try {
            $event_id = isset($data['id']) ? $data['id'] : '';

            if (empty($event_id)) {
                throw new Exception('Event ID is required');
            }

            deleteEvent($conn, $event_id);

            echo json_encode([
                'success' => true,
                'message' => 'Event deleted successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Fetch all services
    case 'fetch_services':
        try {
            $services = fetchServicesWithCategories($conn);
            echo json_encode($services);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Post a new service
    case 'post_service':
        try {
            // Prepare data for createService function
            $serviceData = [
                'title' => isset($data['title']) ? $data['title'] : '',
                'description' => isset($data['description']) ? $data['description'] : '',
                'category_id' => isset($data['category_id']) ? $data['category_id'] : ''
            ];

            // Handle file upload if present in $_FILES
            $file = isset($_FILES['image']) ? $_FILES : [];

            createService($conn, $serviceData, $file);

            echo json_encode([
                'success' => true,
                'message' => 'Service created successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Update an existing service
    case 'update_service':
        try {
            // Prepare data for updateService function
            $serviceData = [
                'id' => isset($data['id']) ? $data['id'] : '',
                'title' => isset($data['title']) ? $data['title'] : '',
                'description' => isset($data['description']) ? $data['description'] : '',
                'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
                'old_image' => isset($data['old_image']) ? $data['old_image'] : ''
            ];

            // Handle file upload if present in $_FILES
            $file = isset($_FILES['image']) ? $_FILES : [];

            updateService($conn, $serviceData, $file);

            echo json_encode([
                'success' => true,
                'message' => 'Service updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Delete a service
    case 'delete_service':
        try {
            $service_id = isset($data['id']) ? $data['id'] : '';

            if (empty($service_id)) {
                throw new Exception('Service ID is required');
            }

            deleteService($conn, $service_id);

            echo json_encode([
                'success' => true,
                'message' => 'Service deleted successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Fetch all categories
    case 'fetch_categories':
        try {
            $categories = fetchCategories($conn);
            echo json_encode($categories);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Post a new category
    case 'post_category':
        try {
            // Prepare data for createCategory function
            $categoryData = [
                'name' => isset($data['name']) ? $data['name'] : '',
                'type' => isset($data['type']) ? $data['type'] : '',
                'description' => isset($data['description']) ? $data['description'] : ''
            ];

            $result = createCategory($conn, $categoryData);

            echo json_encode([
                'success' => true,
                'message' => 'Category created successfully',
                'category_id' => $result
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Update an existing category
    case 'update_category':
        try {
            // Prepare data for updateCategory function
            $categoryData = [
                'id' => isset($data['id']) ? $data['id'] : '',
                'name' => isset($data['name']) ? $data['name'] : '',
                'type' => isset($data['type']) ? $data['type'] : '',
                'description' => isset($data['description']) ? $data['description'] : ''
            ];

            updateCategory($conn, $categoryData);

            echo json_encode([
                'success' => true,
                'message' => 'Category updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Delete a category
    case 'delete_category':
        try {
            $category_id = isset($data['id']) ? $data['id'] : '';

            if (empty($category_id)) {
                throw new Exception('Category ID is required');
            }

            deleteCategory($conn, $category_id);

            echo json_encode([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Fetch categories by type
    case 'fetch_categories_by_type':
        try {
            $type = isset($data['type']) ? $data['type'] : '';

            if (empty($type)) {
                throw new Exception('Category type is required');
            }

            $categories = fetchCategoriesByType($conn, $type);
            echo json_encode($categories);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Fetch all contact submissions
    case 'fetch_contact_submissions':
        try {
            $contacts = fetchContactSubmissionsWithCategories($conn);
            echo json_encode($contacts);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Save general settings
    case 'save_general_settings':
        try {
            $settings = [
                'site_name' => isset($data['site_name']) ? $data['site_name'] : '',
                'site_tagline' => isset($data['site_tagline']) ? $data['site_tagline'] : '',
                'contact_email' => isset($data['contact_email']) ? $data['contact_email'] : '',
                'contact_phone' => isset($data['contact_phone']) ? $data['contact_phone'] : '',
                'address' => isset($data['address']) ? $data['address'] : '',
                'footer_text' => isset($data['footer_text']) ? $data['footer_text'] : ''
            ];

            // Save each setting
            foreach ($settings as $key => $value) {
                saveSetting($conn, 'general', $key, $value);
            }

            echo json_encode([
                'success' => true,
                'message' => 'General settings updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Save social media settings
    case 'save_social_settings':
        try {
            $settings = [
                'facebook' => isset($data['facebook']) ? $data['facebook'] : '',
                'twitter' => isset($data['twitter']) ? $data['twitter'] : '',
                'instagram' => isset($data['instagram']) ? $data['instagram'] : '',
                'linkedin' => isset($data['linkedin']) ? $data['linkedin'] : '',
                'youtube' => isset($data['youtube']) ? $data['youtube'] : ''
            ];

            // Save each setting
            foreach ($settings as $key => $value) {
                saveSetting($conn, 'social', $key, $value);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Social media settings updated successfully'
            ]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    // Default case for unknown events
    default:
        echo json_encode(['error' => 'Unknown event: ' . $event]);
        break;
}
?>