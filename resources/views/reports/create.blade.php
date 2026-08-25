@extends('layouts.app')

@section('title', 'Report ' . ucfirst($type) . ' - E-Benta')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Link -->
            <a href="javascript:history.back()" style="color: var(--light-green); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                <i class="fas fa-arrow-left"></i>Back
            </a>

            <!-- Header -->
            <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.05) 100%); border-left: 4px solid #e74c3c; padding: 2rem; border-radius: 1rem; margin-bottom: 2.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="background: rgba(231, 76, 60, 0.2); padding: 0.75rem 1rem; border-radius: 0.8rem;">
                        <i class="fas fa-flag" style="color: #e74c3c; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h1 style="color: var(--text-light); font-weight: 800; margin: 0; font-size: 2rem;">Report {{ ucfirst($type) }}</h1>
                        <p style="color: #a4b8b5; margin: 0; font-weight: 500;">Help us keep E-Benta safe and fair</p>
                    </div>
                </div>
            </div>

            <!-- Item Information Card -->
            <div style="background: linear-gradient(135deg, rgba(15, 40, 24, 0.8) 0%, rgba(15, 40, 24, 0.4) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem;">
                <p style="color: #64748b; margin: 0 0 1rem 0; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                    Item Being Reported
                </p>
                
                @if($type === 'listing')
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                        <div>
                            <h5 style="color: var(--text-light); font-weight: 700; margin: 0 0 0.5rem 0;">{{ $item->category }}</h5>
                            <p style="color: #64748b; margin: 0; font-size: 0.95rem;">
                                Listed by: <strong>{{ $item->seller->name }}</strong><br>
                                Status: <strong style="color: var(--light-green);">{{ ucfirst($item->status) }}</strong>
                            </p>
                        </div>
                        <span style="background: linear-gradient(135deg, var(--light-green) 0%, #0d9488 100%); color: var(--dark-bg); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.85rem; font-weight: 700;">
                            <i class="fas fa-box me-1"></i>Listing
                        </span>
                    </div>
                @elseif($type === 'offer')
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                        <div>
                            <h5 style="color: var(--text-light); font-weight: 700; margin: 0 0 0.5rem 0;">{{ $item->listing->category }}</h5>
                            <p style="color: #a4b8b5; margin: 0; font-size: 0.95rem;">
                                Offer from: <strong>{{ $item->buyer->name }}</strong><br>
                                Status: <strong style="color: #3498db;">{{ ucfirst($item->status) }}</strong>
                            </p>
                        </div>
                        <span style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.85rem; font-weight: 700;">
                            <i class="fas fa-handshake me-1"></i>Offer
                        </span>
                    </div>
                @else
                    <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                        <div>
                            <h5 style="color: var(--text-light); font-weight: 700; margin: 0 0 0.5rem 0;">{{ $item->name }}</h5>
                            <p style="color: #64748b; margin: 0; font-size: 0.95rem;">
                                Email: <strong>{{ $item->email }}</strong><br>
                                Member since: <strong>{{ $item->created_at->format('M Y') }}</strong>
                            </p>
                        </div>
                        <span style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.85rem; font-weight: 700;">
                            <i class="fas fa-user me-1"></i>User
                        </span>
                    </div>
                @endif
            </div>

            <!-- Report Form Card -->
            <div style="background: linear-gradient(135deg, rgba(15, 40, 24, 0.8) 0%, rgba(15, 40, 24, 0.4) 100%); border: 1px solid rgba(13, 148, 136, 0.2); padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);">
                <form method="POST" action="{{ route('reports.store') }}">
                    @csrf

                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="id" value="{{ $id }}">

                    <!-- Reason -->
                    <div style="margin-bottom: 2rem;">
                        <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.75rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-exclamation-circle me-2" style="color: #e74c3c;"></i>Reason for Report *
                        </label>
                        <select name="reason" required style="width: 100%; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(13, 148, 136, 0.2); color: var(--text-light); padding: 0.9rem 1rem; border-radius: 0.6rem; font-size: 1rem; font-family: inherit;">
                            <option value="" style="background: #ffffff;">Select a reason...</option>
                            @foreach($reasons as $key => $label)
                                <option value="{{ $key }}" style="background: #ffffff;" {{ old('reason') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('reason')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom: 2rem;">
                        <label style="color: var(--text-light); font-weight: 700; display: block; margin-bottom: 0.75rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="fas fa-message me-2" style="color: #e74c3c;"></i>Details (Required) *
                        </label>
                        <textarea name="description" 
                                  placeholder="Please provide detailed information about why you're reporting this. Include specific examples or evidence if possible."
                                  required minlength="10"
                                  style="width: 100%; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(13, 148, 136, 0.2); color: var(--text-light); padding: 0.9rem 1rem; border-radius: 0.6rem; font-size: 1rem; min-height: 150px; font-family: inherit; resize: vertical;">{{ old('description') }}</textarea>
                        <small style="color: #64748b; display: block; margin-top: 0.5rem;">
                            Minimum 10 characters. Be as detailed as possible to help our review team.
                        </small>
                        @error('description')
                            <small style="color: #e74c3c; display: block; margin-top: 0.5rem;">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Information Box -->
                    <div style="background: rgba(52, 152, 219, 0.15); padding: 1rem; border-radius: 0.6rem; margin-bottom: 2rem; border-left: 3px solid #3498db;">
                        <p style="margin: 0; color: #64748b; font-size: 0.95rem;">
                            <i class="fas fa-info-circle me-2" style="color: #3498db;"></i>
                            Your report will be reviewed by our moderation team within 24-48 hours. Please note that false or spam reports may result in account restrictions.
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div style="display: flex; gap: 1rem;">
                        <a href="javascript:history.back()" class="btn" style="flex: 1; background: rgba(255, 255, 255, 0.08); color: var(--text-light); border: 1px solid rgba(13, 148, 136, 0.2); font-weight: 700; padding: 0.9rem 1.5rem; border-radius: 0.6rem; text-decoration: none; text-align: center;">
                            Cancel
                        </a>
                        <button type="submit" class="btn" style="flex: 1; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none; font-weight: 700; padding: 0.9rem 1.5rem; border-radius: 0.6rem; cursor: pointer;">
                            <i class="fas fa-flag me-2"></i>Submit Report
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
select:focus,
textarea:focus {
    background: rgba(255, 255, 255, 0.12) !important;
    border-color: rgba(13, 148, 136, 0.4) !important;
    color: var(--text-light) !important;
    box-shadow: 0 0 0 0.2rem rgba(13, 148, 136, 0.15) !important;
}

select::placeholder,
textarea::placeholder {
    color: #7f9e9a;
}
</style>
@endsection
