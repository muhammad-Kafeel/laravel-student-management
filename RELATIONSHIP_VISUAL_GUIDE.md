# Laravel Eloquent Relationships Visual Guide

## 📊 Database Relationship Diagram

```
┌─────────────────────┐
│   TEACHERS TABLE    │
├─────────────────────┤
│ id (Primary Key)    │◄──────────┐
│ name                │           │
│ address             │           │
│ mobile              │           │
│ created_at          │           │
│ updated_at          │           │
└─────────────────────┘           │
                                  │
                                  │ Foreign Key
                                  │ (One-to-Many)
                                  │
┌─────────────────────┐           │
│   COURSES TABLE     │           │
├─────────────────────┤           │
│ id (Primary Key)    │           │
│ name                │           │
│ syllabus            │           │
│ duration            │           │
│ teacher_id ─────────┼───────────┘
│ created_at          │
│ updated_at          │
└─────────────────────┘
```

## 🔄 How It Works

### One-to-Many Relationship

```
1 Teacher  →  Many Courses

Example:
Teacher "John Doe" (id: 1)
  └─ Course "Laravel Basics" (teacher_id: 1)
  └─ Course "Advanced PHP" (teacher_id: 1)
  └─ Course "Vue.js Intro" (teacher_id: 1)

Teacher "Jane Smith" (id: 2)
  └─ Course "React Fundamentals" (teacher_id: 2)
  └─ Course "Node.js API" (teacher_id: 2)
```

---

## 💻 Code Examples

### In Controller

```php
// Get a teacher with ALL their courses (2 queries total)
$teacher = Teacher::with('courses')->find(1);

// Access courses
$courses = $teacher->courses;  // Collection of Course models

// Count courses
$count = $teacher->courses->count();  // Integer
```

### In Blade View

```blade
<!-- Display teacher name -->
<h3>{{ $teacher->name }}</h3>

<!-- Display course count -->
<p>Teaches {{ $teacher->courses->count() }} courses</p>

<!-- Loop through all courses -->
@foreach($teacher->courses as $course)
    <div class="course-card">
        <h4>{{ $course->name }}</h4>
        <p>{{ $course->duration }}</p>
    </div>
@endforeach
```

---

## 🎯 Real World Flow

### When Admin Creates a Course:

```
1. Admin fills form:
   ┌─────────────────────┐
   │ Course Name: Laravel│
   │ Syllabus: ...       │
   │ Duration: 3 Months  │
   │ Teacher: John Doe   │◄── Dropdown with all teachers
   └─────────────────────┘

2. Form submits to CourseController::store()

3. Laravel validates:
   ✓ Course name is required
   ✓ Teacher ID exists in teachers table

4. Laravel saves to database:
   INSERT INTO courses (name, syllabus, duration, teacher_id)
   VALUES ('Laravel', '...', '3 Months', 1)

5. Redirect to courses list
```

### When User Views Teacher Profile:

```
1. User clicks on teacher

2. TeacherController::show($id) runs:
   $teacher = Teacher::with('courses')->find($id);

3. Laravel runs 2 queries:
   Query 1: SELECT * FROM teachers WHERE id = ?
   Query 2: SELECT * FROM courses WHERE teacher_id = ?

4. View renders:
   - Teacher info
   - Course count
   - List of all courses
```

---

## 🔍 Query Examples

### Without Eager Loading (Bad - N+1 Problem)

```php
$teacher = Teacher::find(1);  // 1 query

// In blade, this triggers 1 query PER course:
@foreach($teacher->courses as $course)
    {{ $course->name }}  // Query each time!
@endforeach

// Total: 1 + N queries (if teacher has 10 courses = 11 queries!)
```

### With Eager Loading (Good)

```php
$teacher = Teacher::with('courses')->find(1);  // 2 queries total

// In blade, no additional queries:
@foreach($teacher->courses as $course)
    {{ $course->name }}  // Uses loaded data
@endforeach

// Total: Always 2 queries, regardless of course count
```

---

## 📝 Method Cheat Sheet

### On Teacher Model:

```php
$teacher->courses              // Get all courses (Collection)
$teacher->courses()->get()     // Same as above
$teacher->courses()->count()   // Count courses (runs query)
$teacher->courses->count()     // Count from loaded data (no query)
$teacher->courses()->where()   // Add conditions
$teacher->courses()->first()   // Get first course
```

### On Course Model:

```php
$course->teacher              // Get the teacher (Model or null)
$course->teacher_id           // Get teacher ID (Integer or null)
```

---

## 🎨 What You See vs What Happens

### On Teacher Profile Page:

**What You See:**
```
Audieeee
Student ID: #2
📞 1-563-801-1283
📍 1828 Sandrine Course Suite 135

Courses: 3 Enrolled  ◄── This number comes from database

📚 Courses Teaching
┌────────────────────────┐
│ Laravel Basics         │  ◄── These cards come from
│ 3 Months              │      database query
│ Learn Laravel...      │
│ 👥 25 Students        │
└────────────────────────┘
```

**What Happens in Code:**
```php
// Controller
$teacher = Teacher::with('courses')->find(2);

// View
{{ $teacher->courses->count() }}  // Shows "3"

@foreach($teacher->courses as $course)
    <div class="card">
        <h4>{{ $course->name }}</h4>
        <span>{{ $course->duration }}</span>
        <p>{{ $course->syllabus }}</p>
    </div>
@endforeach
```

---

## 🏗️ Architecture Overview

```
┌──────────────────────────────────────────┐
│          PRESENTATION LAYER              │
│  (resources/views/teachers/show.blade)   │
│                                          │
│  Shows teacher info + courses            │
└───────────────┬──────────────────────────┘
                │
                │ Blade syntax: {{ $teacher->courses }}
                │
┌───────────────▼──────────────────────────┐
│         APPLICATION LAYER                │
│   (app/Http/Controllers/               │
│    TeacherController.php)               │
│                                          │
│  $teacher = Teacher::with('courses')     │
│              ->find($id);                │
└───────────────┬──────────────────────────┘
                │
                │ Eloquent ORM
                │
┌───────────────▼──────────────────────────┐
│          DATA ACCESS LAYER               │
│       (app/Models/Teacher.php)           │
│                                          │
│  public function courses() {             │
│      return $this->hasMany(Course);      │
│  }                                       │
└───────────────┬──────────────────────────┘
                │
                │ SQL Queries
                │
┌───────────────▼──────────────────────────┐
│          DATABASE LAYER                  │
│   (MySQL/PostgreSQL/SQLite)              │
│                                          │
│  teachers table + courses table          │
└──────────────────────────────────────────┘
```

---

## 💡 Key Concepts for Beginners

### 1. Foreign Key = Link Between Tables
```
teacher_id in courses table
    ↓
Links to id in teachers table
```

### 2. Collection vs Model
```php
$teacher           // Single Teacher model
$teacher->courses  // Collection of Course models (like an array)
```

### 3. Lazy vs Eager Loading
```php
// Lazy (loads when accessed)
$teacher = Teacher::find(1);
$courses = $teacher->courses;  // Query happens here

// Eager (loads upfront)
$teacher = Teacher::with('courses')->find(1);
$courses = $teacher->courses;  // No query, already loaded
```

### 4. Relationship Direction
```php
// From teacher to courses (One-to-Many)
$teacher->courses

// From course to teacher (Inverse - Many-to-One)
$course->teacher
```

---

## ✨ Summary

- **One teacher** can teach **many courses**
- **Each course** belongs to **one teacher** (or none)
- Use `with('courses')` to load relationships efficiently
- Access with `$teacher->courses` (plural)
- Access inverse with `$course->teacher` (singular)

---

## 📚 Further Learning

1. **Laravel Docs:** https://laravel.com/docs/10.x/eloquent-relationships
2. **Try in Tinker:** `php artisan tinker`
3. **Practice:** Create more relationships (students, enrollments)

Happy Learning! 🚀
