<div class="mb-3">
  <label for="name" class="form-label">Name</label>
  <input type="text" name="name" value="{{ old('name', $model->name) }}" class="form-control @error('name') is-invalid @enderror" id="name">
  @error('name')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="mb-3">
  <label for="email" class="form-label">Email Address</label>
  <input type="email" name="email" value="{{ old('email', $model->email) }}" class="form-control @error('email') is-invalid @enderror" id="email">
  @error('email')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="mb-3">
  <label for="password" class="form-label">Password</label>
  <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
  @error('password')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
<div class="mb-3">
  <label for="password_confirmation" class="form-label">Re-enter Password</label>
  <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
  @error('password_confirmation')
  <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>
  