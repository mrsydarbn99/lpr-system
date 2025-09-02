<div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" name="name" value="{{ old('name',$model->name) }}" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1">
    @error('name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Phone Num</label>
    <input type="text" name="phone_num" value="{{ old('phone_num',$model->phone_num) }}" class="form-control @error('phone_num') is-invalid @enderror" id="exampleInputPassword1">
    @error('phone_num')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Plate Num</label>
    <input type="text" name="plate_num" value="{{ old('plate_num',$model->plate_num) }}" class="form-control @error('plate_num') is-invalid @enderror" id="exampleInputPassword1">
    @error('plate_num')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Days</label>
    <select class="form-select @error('days') is-invalid @enderror mb-3" aria-label="Default select example" name="days" id="days">
        @for ($i = 1; $i < 8; $i++)
          <option value="{{ $i }}" {{ old('days', $model->days) == $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    @error('days')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>