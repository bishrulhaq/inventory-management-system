@extends('layouts.admin_master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Settings</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                           class="form-control">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="profile_picture">Profile Picture</label>
                    <input type="file" id="profile_picture" name="profile_picture" class="form-control" onchange="previewImage(event)">
                    <img id="imagePreview" src="#" alt="Profile Image Preview" style="display: none; max-width: 200px; margin-top: 10px;">
                    @error('profile_picture')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select id="user_type" name="user_type" class="form-control">
                        <option value="user" {{ $user->user_type === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->user_type === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('user_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('imagePreview');
            preview.style.display = 'block';
            const reader = new FileReader();
            reader.onload = function () {
                preview.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
