<?php
namespace Tests\Feature;
use Database\Factories\StudentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

Class StudentTest extends \Tests\TestCase {
    use RefreshDatabase;

    public function test_get_all_students() {
        // Arrange
        StudentFactory::new()->count(10)->create();

        // Act
        $response = $this->json('get', route('students.index'));

        // Assert
        $response->assertStatus(200)->assertJsonCount(10);
    }

    public function test_get_studnet_create() {
    // act
        $response = $this->json('get', route('students.create'));

    // Assert
        $response->assertStatus(200)->assertSeeText([]);
    }

    public function test_store_student() {

        $student = [
            'roll_no' => '1416',
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '0123456789'
        ];

        $response = $this->json('post', route('students.store'), $student);
        $response->assertStatus(200);
        $this->assertDatabaseHas('students', $student);
    }

    public function test_show_student() {
        $student = StudentFactory::new()->create();

        $response = $this->json('get', route('students.show', ['id' => $student->id]));
        $response->assertStatus(200)->assertJson([
            'id' => $student->id,
            'roll_no' => $student->roll_no,
            'name' => $student->name,
            'email' => $student->email,
            'phone' => $student->phone
        ]);
    }

    public function test_update_student() {
        $student = StudentFactory::new()->create();

        $newStudent = [
            'roll_no' => '1416',
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'phone' => '0123456789'
        ];

        $response = $this->json('put', route('students.update', ['id' => $student->id]), $newStudent);

        $response->assertStatus(200);
        $this->assertDatabaseHas('students', $newStudent);
        $this->assertDatabaseMissing('students', $student->toArray());
    }

    public function test_destroy_student() {
        $student = StudentFactory::new()->create();
        $response = $this->json('delete', route('students.destroy', $student->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
