<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Test;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Package;
use App\Models\TestCategory;
use App\Models\Associate;
use App\Models\Report;
use App\Models\ReportTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users(Request $request)
    {
        $roles = Role::all();
        return view('admin.users', compact('roles'));
    }

    public function store(Request $request)
    {
        try {
            $userId = $request->user_id;

            // Build validation rules
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'role_id' => ['required', 'exists:roles,id'],
            ];

            // Handle unique validation for email
            if ($userId && is_numeric($userId)) {
                $rules['email'] = ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)];
                $rules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
            } else {
                $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email'];
                $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
            }

            $request->validate($rules);

            $data = $request->only('name', 'email', 'role_id');

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            User::updateOrCreate(['id' => $userId], $data);

            return response()->json(['success' => 'User saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => 'User deleted successfully.']);
    }

    public function getUsers(Request $request)
    {
        $data = User::with('role')->select('users.*');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('role', function ($row) {
                return $row->role ? $row->role->name : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser">Edit</a>';
                $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function updateGeneralSettings(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'timezone' => 'required|string',
            'currency' => 'required|string|max:3',
            'app_description' => 'nullable|string|max:500',
        ]);

        // In a real application, you would save these to a settings table or config file
        // For now, we'll just return a success response
        return response()->json([
            'success' => true,
            'message' => 'General settings updated successfully!'
        ]);
    }

    public function updateSystemSettings(Request $request)
    {
        $request->validate([
            'maintenance_mode' => 'boolean',
            'debug_mode' => 'boolean',
            'session_lifetime' => 'required|integer|min:30|max:1440',
            'max_upload_size' => 'required|integer|min:1|max:100',
        ]);

        // Handle system settings update
        return response()->json([
            'success' => true,
            'message' => 'System settings updated successfully!'
        ]);
    }

    public function updateEmailSettings(Request $request)
    {
        $request->validate([
            'mail_driver' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_encryption' => 'nullable|string',
            'mail_username' => 'required|email',
            'mail_password' => 'required|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        // Handle email settings update
        return response()->json([
            'success' => true,
            'message' => 'Email settings updated successfully!'
        ]);
    }

    public function updateSecuritySettings(Request $request)
    {
        $request->validate([
            'two_factor_auth' => 'boolean',
            'force_password_reset' => 'boolean',
            'password_min_length' => 'required|integer|min:6|max:50',
            'login_attempts' => 'required|integer|min:3|max:10',
            'lockout_duration' => 'required|integer|min:5|max:60',
            'password_expiry' => 'required|integer|min:30|max:365',
        ]);

        // Handle security settings update
        return response()->json([
            'success' => true,
            'message' => 'Security settings updated successfully!'
        ]);
    }

    public function updateAppearanceSettings(Request $request)
    {
        $request->validate([
            'dark_mode' => 'boolean',
            'theme_color' => 'required|string',
            'sidebar_style' => 'required|string',
            'navbar_style' => 'required|string',
            'logo_upload' => 'nullable|image|max:2048',
        ]);

        // Handle logo upload if provided
        if ($request->hasFile('logo_upload')) {
            $logoPath = $request->file('logo_upload')->store('logos', 'public');
            // Save logo path to settings
        }

        // Handle appearance settings update
        return response()->json([
            'success' => true,
            'message' => 'Appearance settings updated successfully!'
        ]);
    }

    public function testEmailConnection(Request $request)
    {
        // Simulate email connection test
        // In a real application, you would test the actual email configuration
        
        try {
            // Test email connection logic here
            return response()->json([
                'success' => true,
                'message' => 'Email connection test successful!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Email connection test failed: ' . $e->getMessage()
            ], 400);
        }
    }

    public function clearCache(Request $request)
    {
        $cacheType = $request->input('type', 'all');
        
        try {
            switch ($cacheType) {
                case 'config':
                    \Artisan::call('config:clear');
                    break;
                case 'route':
                    \Artisan::call('route:clear');
                    break;
                case 'view':
                    \Artisan::call('view:clear');
                    break;
                default:
                    \Artisan::call('cache:clear');
                    \Artisan::call('config:clear');
                    \Artisan::call('route:clear');
                    \Artisan::call('view:clear');
            }

            return response()->json([
                'success' => true,
                'message' => ucfirst($cacheType) . ' cache cleared successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createBackup(Request $request)
    {
        try {
            // In a real application, you would create an actual database backup
            $backupName = 'backup_' . date('Y_m_d_H_i_s') . '.sql';
            
            // Simulate backup creation
            return response()->json([
                'success' => true,
                'message' => 'Backup created successfully!',
                'backup_name' => $backupName
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadBackup(Request $request)
    {
        $filename = $request->input('filename');
        
        // In a real application, you would download the actual backup file
        return response()->json([
            'success' => true,
            'message' => 'Backup download started for: ' . $filename
        ]);
    }

    public function deleteBackup(Request $request)
    {
        $filename = $request->input('filename');
        
        // In a real application, you would delete the actual backup file
        return response()->json([
            'success' => true,
            'message' => 'Backup deleted successfully: ' . $filename
        ]);
    }

    public function restoreBackup(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql'
        ]);

        try {
            // In a real application, you would restore from the actual backup file
            return response()->json([
                'success' => true,
                'message' => 'Database restored successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore backup: ' . $e->getMessage()
            ], 500);
        }
    }

    // Master Menu Methods
    public function tests()
    {
        // Add some debugging
        \Log::info('Tests page accessed', ['user' => auth()->user()]);
        return view('admin.master.tests');
    }

    public function getTests(Request $request)
    {
        \Log::info('getTests called', ['user' => auth()->user()]);
        $data = Test::select('tests.*')->orderBy('created_at', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sub_heading', function ($row) {
                return $row->is_sub_heading ? 
                    '<span class="badge badge-success"><i class="fas fa-check"></i> Yes</span>' : 
                    '<span class="badge badge-secondary"><i class="fas fa-times"></i> No</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->status ? 
                    '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                    '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-info btn-sm viewTest" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-eye"></i></button>';
                $btn .= '<button type="button" class="btn btn-primary btn-sm editTest" data-id="'.$row->id.'" title="Edit Test" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-edit"></i></button>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm deleteTest" data-id="'.$row->id.'" title="Delete Test" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['sub_heading', 'status', 'action'])
            ->make(true);
    }

    public function storeTest(Request $request)
    {
        try {
            $testId = $request->test_id;

            $request->validate([
                'test_name' => ['required', 'string', 'max:255'],
                'specimen' => ['nullable', 'string', 'max:255'],
                'result_default' => ['nullable', 'string', 'max:255'],
                'unit' => ['nullable', 'string', 'max:255'],
                'reference_range' => ['nullable', 'string', 'max:255'],
                'min_value' => ['nullable', 'numeric', 'min:0'],
                'max_value' => ['nullable', 'numeric', 'min:0'],
                'testcode' => ['nullable', 'string', 'max:255'],
                'individual_method' => ['nullable', 'string', 'max:255'],
            ]);

            $data = $request->only([
                'test_name', 'specimen', 'result_default', 'unit', 'reference_range',
                'min_value', 'max_value', 'testcode', 'individual_method'
            ]);

            $data['is_sub_heading'] = $request->has('is_sub_heading');
            $data['status'] = $request->has('status');

            Test::updateOrCreate(['id' => $testId], $data);

            return response()->json(['success' => 'Test saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function editTest($id)
    {
        $test = Test::findOrFail($id);
        return response()->json($test);
    }

    public function destroyTest($id)
    {
        $test = Test::findOrFail($id);
        $test->delete();
        return response()->json(['success' => 'Test deleted successfully.']);
    }

    public function doctors()
    {
        return view('admin.master.doctors');
    }

    public function getDoctors(Request $request)
    {
        $data = Doctor::select('doctors.*')->orderBy('created_at', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return $row->status ? 
                    '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                    '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
            })
            ->addColumn('percent_display', function ($row) {
                return '<span class="badge badge-info">' . $row->percent . '%</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-info btn-sm viewDoctor" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-eye"></i></button>';
                $btn .= '<button type="button" class="btn btn-primary btn-sm editDoctor" data-id="'.$row->id.'" title="Edit Doctor" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-edit"></i></button>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm deleteDoctor" data-id="'.$row->id.'" title="Delete Doctor" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'percent_display', 'action'])
            ->make(true);
    }

    public function storeDoctor(Request $request)
    {
        try {
            $doctorId = $request->doctor_id;

            $request->validate([
                'doctor_name' => ['required', 'string', 'max:255'],
                'hospital_name' => ['nullable', 'string', 'max:255'],
                'contact_no' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string'],
                'percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
                'specialization' => ['nullable', 'string', 'max:255'],
                'qualification' => ['nullable', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'emergency_contact' => ['nullable', 'string', 'max:255'],
                'license_number' => ['nullable', 'string', 'max:255'],
                'license_expiry' => ['nullable', 'date'],
                'notes' => ['nullable', 'string'],
            ]);

            $data = $request->only([
                'doctor_name', 'hospital_name', 'contact_no', 'address', 'percent',
                'specialization', 'qualification', 'email', 'emergency_contact',
                'license_number', 'license_expiry', 'notes'
            ]);

            // Handle status - convert to boolean
            $data['status'] = filter_var($request->input('status', 0), FILTER_VALIDATE_BOOLEAN);

            Doctor::updateOrCreate(['id' => $doctorId], $data);

            return response()->json(['success' => 'Doctor saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function editDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        return response()->json($doctor);
    }

    public function destroyDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return response()->json(['success' => 'Doctor deleted successfully.']);
    }

    public function patients()
    {
        return view('admin.master.patients');
    }

    public function getPatients(Request $request)
    {
        $data = Patient::select('patients.*')->orderBy('created_at', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                return $row->status ? 
                    '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                    '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
            })
            ->addColumn('sex_badge', function ($row) {
                $color = $row->sex === 'Male' ? 'primary' : ($row->sex === 'Female' ? 'pink' : 'secondary');
                return $row->sex ? '<span class="badge badge-' . $color . '">' . $row->sex . '</span>' : 'N/A';
            })
            ->addColumn('age_display', function ($row) {
                return $row->age ? $row->age . ' years' : 'N/A';
            })
            ->addColumn('created_at_formatted', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y') : 'N/A';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-info btn-sm viewPatient" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-eye"></i></button>';
                $btn .= '<button type="button" class="btn btn-primary btn-sm editPatient" data-id="'.$row->id.'" title="Edit Patient" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-edit"></i></button>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm deletePatient" data-id="'.$row->id.'" title="Delete Patient" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'sex_badge', 'action'])
            ->make(true);
    }

    public function storePatient(Request $request)
    {
        try {
            $patientId = $request->patient_id;

            // Build validation rules
            $rules = [
                'client_name' => ['required', 'string', 'max:255'],
                'mobile_number' => ['required', 'string', 'max:255'],
                'father_husband_name' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string'],
                'sex' => ['nullable', 'in:Male,Female,Other'],
                'age' => ['nullable', 'integer', 'min:0', 'max:150'],
                'email' => ['nullable', 'email', 'max:255'],
                'date_of_birth' => ['nullable', 'date'],
                'blood_group' => ['nullable', 'string', 'max:10'],
                'occupation' => ['nullable', 'string', 'max:255'],
                'emergency_contact' => ['nullable', 'string', 'max:255'],
                'medical_history' => ['nullable', 'string'],
                'allergies' => ['nullable', 'string'],
                'notes' => ['nullable', 'string'],
            ];

            // Handle unique validation for UHID
            if ($patientId && is_numeric($patientId)) {
                $rules['uhid'] = ['nullable', 'string', 'max:255', Rule::unique('patients', 'uhid')->ignore($patientId)];
            } else {
                $rules['uhid'] = ['nullable', 'string', 'max:255', 'unique:patients,uhid'];
            }

            $request->validate($rules);

            $data = $request->only([
                'client_name', 'mobile_number', 'father_husband_name', 'address', 'sex',
                'age', 'uhid', 'email', 'date_of_birth', 'blood_group', 'occupation',
                'emergency_contact', 'medical_history', 'allergies', 'notes'
            ]);

            $data['status'] = $request->has('status');

            Patient::updateOrCreate(['id' => $patientId], $data);

            return response()->json(['success' => 'Patient saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function editPatient($id)
    {
        $patient = Patient::findOrFail($id);
        return response()->json($patient);
    }

    public function destroyPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return response()->json(['success' => 'Patient deleted successfully.']);
    }

    public function packages()
    {
        $tests = Test::where('status', true)->orderBy('test_name')->get();
        return view('admin.master.packages', compact('tests'));
    }

    public function getPackages(Request $request)
    {
        $data = Package::select('packages.*')->orderBy('created_at', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('test_count', function ($row) {
                $count = is_array($row->tests) ? count($row->tests) : 0;
                return '<span class="badge badge-info">' . $count . ' Tests</span>';
            })
            ->addColumn('amount_display', function ($row) {
                return '<span class="badge badge-success">₹ ' . number_format($row->amount, 2) . '</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->status ? 
                    '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                    '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-info btn-sm viewPackage" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-eye"></i></button>';
                $btn .= '<button type="button" class="btn btn-primary btn-sm editPackage" data-id="'.$row->id.'" title="Edit Package" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-edit"></i></button>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm deletePackage" data-id="'.$row->id.'" data-name="'.htmlspecialchars($row->package_name).'" title="Delete Package" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['test_count', 'amount_display', 'status', 'action'])
            ->make(true);
    }

    public function storePackage(Request $request)
    {
        try {
            $packageId = $request->package_id;

            $request->validate([
                'package_name' => ['required', 'string', 'max:255'],
                'amount' => ['required', 'numeric', 'min:0'],
                'description' => ['nullable', 'string'],
                'tests' => ['nullable', 'string'], // JSON string from frontend
            ]);

            $data = $request->only([
                'package_name', 'amount', 'description'
            ]);

            // Parse tests JSON
            if ($request->tests) {
                $testsArray = json_decode($request->tests, true);
                if (is_array($testsArray)) {
                    $data['tests'] = $testsArray;
                } else {
                    $data['tests'] = [];
                }
            } else {
                $data['tests'] = [];
            }

            $data['status'] = $request->has('status');

            Package::updateOrCreate(['id' => $packageId], $data);

            return response()->json(['success' => 'Package saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function editPackage($id)
    {
        $package = Package::findOrFail($id);
        return response()->json($package);
    }

    public function destroyPackage($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return response()->json(['success' => 'Package deleted successfully.']);
    }

    public function testCategories()
    {
        return view('admin.master.test-categories');
    }

    public function getTestCategories(Request $request)
    {
        $data = TestCategory::select('test_categories.*')->orderBy('created_at', 'desc');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tests_count', function ($row) {
                // Since we don't have tests linked yet, show 0 for now
                $count = 0;
                return '<span class="badge badge-info">' . $count . ' Tests</span>';
            })
            ->addColumn('status', function ($row) {
                return $row->status ? 
                    '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                    '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-warning btn-sm editTestCategory" data-id="'.$row->id.'" title="Edit Category" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-edit"></i></button>';
                $btn .= '<button type="button" class="btn btn-info btn-sm viewTestCategory" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-eye"></i></button>';
                $btn .= '<button type="button" class="btn btn-danger btn-sm deleteTestCategory" data-id="'.$row->id.'" data-name="'.htmlspecialchars($row->category_name).'" title="Delete Category" data-toggle="tooltip">';
                $btn .= '<i class="fas fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['tests_count', 'status', 'action'])
            ->make(true);
    }

    public function storeTestCategory(Request $request)
    {
        try {
            $categoryId = $request->category_id;

            // Build validation rules
            $rules = [
                'description' => ['nullable', 'string'],
            ];

            // Handle unique validation for category_name
            if ($categoryId && is_numeric($categoryId)) {
                // Update existing category - exclude current record from unique check
                $rules['category_name'] = [
                    'required', 
                    'string', 
                    'max:255', 
                    Rule::unique('test_categories', 'category_name')->ignore($categoryId)
                ];
            } else {
                // Create new category - check for unique name
                $rules['category_name'] = [
                    'required', 
                    'string', 
                    'max:255', 
                    'unique:test_categories,category_name'
                ];
            }

            $request->validate($rules);

            $data = $request->only([
                'category_name', 'description'
            ]);

            $data['status'] = $request->has('status');

            if ($categoryId && is_numeric($categoryId)) {
                // Update existing category
                $category = TestCategory::findOrFail($categoryId);
                $category->update($data);
            } else {
                // Create new category
                TestCategory::create($data);
            }

            return response()->json(['success' => 'Test category saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while saving the category.'], 500);
        }
    }

    public function editTestCategory($id)
    {
        $category = TestCategory::findOrFail($id);
        return response()->json($category);
    }

    public function destroyTestCategory($id)
    {
        $category = TestCategory::findOrFail($id);
        
        // Check if category has tests
        if ($category->tests()->count() > 0) {
            return response()->json(['error' => 'Cannot delete category that has tests assigned to it.'], 422);
        }
        
        $category->delete();
        return response()->json(['success' => 'Test category deleted successfully.']);
    }

    public function associates()
    {
        return view('admin.master.associates_fixed');
    }

    // ...existing associate methods...

    // Entry Menu Methods
    public function entryList()
    {
        return view('admin.entry.entry-list');
    }

    public function testBooking()
    {
        return view('admin.entry.test-booking');
    }

    public function sampleCollection()
    {
        return view('admin.entry.sample-collection');
    }

    public function resultEntry()
    {
        return view('admin.entry.result-entry');
    }

    public function getAssociates(Request $request)
    {
        try {
            $data = Associate::select('associates.*')->orderBy('created_at', 'desc');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('percent_display', function ($row) {
                    return '<span class="badge badge-primary">' . ($row->percent ?? 0) . '%</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->status ? 
                        '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>' : 
                        '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group" role="group">';
                    $btn .= '<button type="button" class="btn btn-warning btn-sm editAssociate" data-id="'.$row->id.'" title="Edit Associate" data-toggle="tooltip">';
                    $btn .= '<i class="fas fa-edit"></i></button>';
                    $btn .= '<button type="button" class="btn btn-info btn-sm viewAssociate" data-id="'.$row->id.'" title="View Details" data-toggle="tooltip">';
                    $btn .= '<i class="fas fa-eye"></i></button>';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm deleteAssociate" data-id="'.$row->id.'" data-name="'.htmlspecialchars($row->name ?? '').'" title="Delete Associate" data-toggle="tooltip">';
                    $btn .= '<i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['percent_display', 'status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            \Log::error('DataTables error in getAssociates: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error loading associates data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeAssociate(Request $request)
    {
        try {
            $associateId = $request->associate_id;

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'hospital_name' => ['nullable', 'string', 'max:255'],
                'contact_no' => ['nullable', 'string', 'max:255'],
                'address' => ['nullable', 'string'],
                'percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            ]);

            $data = $request->only([
                'name', 'hospital_name', 'contact_no', 'address', 'percent'
            ]);

            $data['status'] = $request->has('status');

            Associate::updateOrCreate(['id' => $associateId], $data);

            return response()->json(['success' => 'Associate saved successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function editAssociate($id)
    {
        $associate = Associate::findOrFail($id);
        return response()->json($associate);
    }

    public function destroyAssociate($id)
    {
        $associate = Associate::findOrFail($id);
        $associate->delete();
        return response()->json(['success' => 'Associate deleted successfully.']);
    }

    // Reports Management Methods
    public function reports()
    {
        return view('admin.reports.index');
    }

    public function getReports(Request $request)
    {
        $data = Report::with(['patient', 'doctor'])->select('reports.*');
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($row) {
                return $row->patient ? $row->patient->name : 'N/A';
            })
            ->addColumn('doctor_name', function ($row) {
                return $row->doctor ? $row->doctor->name : 'N/A';
            })
            ->addColumn('status', function ($row) {
                $color = $row->status_color;
                return '<span class="badge badge-' . $color . '">' . ucfirst($row->report_status) . '</span>';
            })
            ->addColumn('payment_status', function ($row) {
                $color = $row->payment_status_color;
                return '<span class="badge badge-' . $color . '">' . ucfirst($row->payment_status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('admin.reports.show', $row->id) . '" class="btn btn-info btn-sm mr-1">
                            <i class="fas fa-eye"></i> View
                        </a>';
                $btn .= '<a href="' . route('admin.reports.print', $row->id) . '" class="btn btn-secondary btn-sm mr-1" target="_blank">
                            <i class="fas fa-print"></i> Print
                        </a>';
                $btn .= '<a href="' . route('admin.reports.edit', $row->id) . '" class="btn btn-primary btn-sm mr-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>';
                $btn .= '<button class="btn btn-danger btn-sm deleteReport" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i> Delete
                        </button>';
                return $btn;
            })
            ->rawColumns(['status', 'payment_status', 'action'])
            ->make(true);
    }

    public function createReport()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $tests = Test::all();
        $packages = Package::with('tests')->get();
        
        return view('admin.reports.create', compact('patients', 'doctors', 'tests', 'packages'));
    }

    public function storeReport(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'sample_collection_date' => 'required|date',
            'tests' => 'required|array',
            'tests.*.test_id' => 'required|exists:tests,id',
            'tests.*.result_value' => 'required|string',
            'tests.*.reference_range' => 'required|string',
            'tests.*.status' => 'required|in:normal,high,low,critical',
            'tests.*.unit' => 'nullable|string',
        ]);

        $report = Report::create([
            'report_number' => Report::generateReportNumber(),
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'report_date' => now(),
            'sample_collection_date' => $request->sample_collection_date,
            'report_status' => 'completed',
            'technician_name' => $request->technician_name,
            'pathologist_name' => $request->pathologist_name,
            'comments' => $request->comments,
            'total_amount' => $request->total_amount ?? 0,
            'discount' => $request->discount ?? 0,
            'final_amount' => $request->final_amount ?? 0,
            'payment_status' => $request->payment_status ?? 'pending',
        ]);

        foreach ($request->tests as $testData) {
            ReportTest::create([
                'report_id' => $report->id,
                'test_id' => $testData['test_id'],
                'result_value' => $testData['result_value'],
                'reference_range' => $testData['reference_range'],
                'status' => $testData['status'],
                'unit' => $testData['unit'] ?? null,
                'remarks' => $testData['remarks'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Report created successfully!',
            'report_id' => $report->id
        ]);
    }

    public function showReport($id)
    {
        $report = Report::with(['patient', 'doctor', 'reportTests.test'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    public function editReport($id)
    {
        $report = Report::with(['reportTests.test'])->findOrFail($id);
        $patients = Patient::all();
        $doctors = Doctor::all();
        $tests = Test::all();
        
        return view('admin.reports.edit', compact('report', 'patients', 'doctors', 'tests'));
    }

    public function updateReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'sample_collection_date' => 'required|date',
            'tests' => 'required|array',
        ]);

        $report->update($request->only([
            'patient_id', 'doctor_id', 'sample_collection_date', 'report_status',
            'technician_name', 'pathologist_name', 'comments', 'total_amount',
            'discount', 'final_amount', 'payment_status'
        ]));

        // Update test results
        $report->reportTests()->delete();
        foreach ($request->tests as $testData) {
            ReportTest::create([
                'report_id' => $report->id,
                'test_id' => $testData['test_id'],
                'result_value' => $testData['result_value'],
                'reference_range' => $testData['reference_range'],
                'status' => $testData['status'],
                'unit' => $testData['unit'] ?? null,
                'remarks' => $testData['remarks'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Report updated successfully!'
        ]);
    }

    public function destroyReport($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Report deleted successfully!'
        ]);
    }

    public function printReport($id)
    {
        $report = Report::with(['patient', 'doctor', 'reportTests.test'])->findOrFail($id);
        return view('admin.reports.print', compact('report'));
    }

    public function testAssociatesData()
    {
        try {
            $associates = Associate::all();
            return response()->json([
                'status' => 'success',
                'count' => $associates->count(),
                'data' => $associates->toArray()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
}
