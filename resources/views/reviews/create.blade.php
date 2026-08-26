@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; color: white;">
        <h1 style="margin: 0 0 0.5rem 0; font-size: 2rem; font-weight: 800;">
            <i class="fas fa-star me-2"></i>Leave a Review
        </h1>
        <p style="margin: 0; color: rgba(255, 255, 255, 0.8);">Share your experience with {{ $reviewee->name }}</p>
    </div>

    <!-- Reviewee Info -->
    <div style="background: white; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06); border-left: 4px solid #0d9488;">
        <div style="display: flex; gap: 1rem; align-items: center;">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #0d9488, #0d9488); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 800;">
                {{ strtoupper(substr($reviewee->name, 0, 1)) }}
            </div>
            <div>
                <h3 style="margin: 0; color: #2c3e50; font-weight: 700;">{{ $reviewee->name }}</h3>
                <p style="margin: 0.25rem 0 0 0; color: #7f8c8d; font-size: 0.9rem;">{{ $reviewee->isBuyer() ? 'Buyer' : 'Seller' }} • Rating: <strong>{{ $reviewee->getAverageRating() }}/5</strong> ({{ $reviewee->getTotalReviews() }} reviews)</p>
            </div>
        </div>
    </div>

    <!-- Review Form -->
    <form method="POST" action="{{ route('reviews.store', $offer) }}" style="background: white; border-radius: 1rem; padding: 2rem; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);">
        @csrf

        <!-- Overall Rating -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #2c3e50; font-weight: 700; margin-bottom: 1rem; font-size: 1.05rem;">Overall Rating *</label>
            <div style="display: flex; gap: 1rem; font-size: 2.5rem;">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" class="rating-btn" data-rating="{{ $i }}" style="background: none; border: none; cursor: pointer; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="highlightStars({{ $i }})" onmouseout="resetStars()">
                        <i class="fas fa-star"></i>
                    </button>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" value="" required>
            @error('rating')
                <p style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Title -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #2c3e50; font-weight: 700; margin-bottom: 0.75rem;">Review Title *</label>
            <input type="text" name="title" placeholder="Summarize your experience..." style="width: 100%; padding: 0.75rem; border: 1px solid #bdc3c7; border-radius: 0.5rem; font-size: 0.95rem;" value="{{ old('title') }}" required maxlength="100">
            @error('title')
                <p style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.5rem;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Comment -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #2c3e50; font-weight: 700; margin-bottom: 0.75rem;">Your Experience</label>
            <textarea name="comment" placeholder="Tell us more about your experience (optional)" style="width: 100%; padding: 0.75rem; border: 1px solid #bdc3c7; border-radius: 0.5rem; font-size: 0.95rem; min-height: 120px; resize: vertical;" maxlength="1000">{{ old('comment') }}</textarea>
            <small style="color: #7f8c8d; display: block; margin-top: 0.5rem;">0/1000 characters</small>
        </div>

        <!-- Detailed Attributes -->
        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
            <h4 style="margin-top: 0; color: #2c3e50; font-weight: 700; margin-bottom: 1rem;">Rate Specific Aspects (Optional)</h4>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <!-- Communication -->
                <div>
                    <label style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">Communication</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label style="cursor: pointer; font-size: 1.5rem; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="this.style.color='#f39c12'" onmouseout="updateStarColor(this, 'communication')">
                                <input type="radio" name="communication" value="{{ $i }}" style="display: none;" onchange="updateStarColor(this, 'communication')">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Professionalism -->
                <div>
                    <label style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">Professionalism</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label style="cursor: pointer; font-size: 1.5rem; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="this.style.color='#3498db'" onmouseout="updateStarColor(this, 'professionalism')">
                                <input type="radio" name="professionalism" value="{{ $i }}" style="display: none;" onchange="updateStarColor(this, 'professionalism')">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Cleanliness/Condition -->
                <div>
                    <label style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">Item Condition</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label style="cursor: pointer; font-size: 1.5rem; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="this.style.color='#27ae60'" onmouseout="updateStarColor(this, 'cleanliness')">
                                <input type="radio" name="cleanliness" value="{{ $i }}" style="display: none;" onchange="updateStarColor(this, 'cleanliness')">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Accuracy -->
                <div>
                    <label style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">Description Accuracy</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label style="cursor: pointer; font-size: 1.5rem; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="this.style.color='#9b59b6'" onmouseout="updateStarColor(this, 'accuracy')">
                                <input type="radio" name="accuracy" value="{{ $i }}" style="display: none;" onchange="updateStarColor(this, 'accuracy')">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Promptness -->
                <div>
                    <label style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">Promptness</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label style="cursor: pointer; font-size: 1.5rem; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="this.style.color='#e67e22'" onmouseout="updateStarColor(this, 'promptness')">
                                <input type="radio" name="promptness" value="{{ $i }}" style="display: none;" onchange="updateStarColor(this, 'promptness')">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>

                <!-- Honesty -->
                <div>
                    <label style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem;">Honesty & Integrity</label>
                    <div style="display: flex; gap: 0.5rem;">
                        @for($i = 1; $i <= 5; $i++)
                            <label style="cursor: pointer; font-size: 1.5rem; color: #bdc3c7; transition: color 0.2s ease;" onmouseover="this.style.color='#e74c3c'" onmouseout="updateStarColor(this, 'honesty')">
                                <input type="radio" name="honesty" value="{{ $i }}" style="display: none;" onchange="updateStarColor(this, 'honesty')">
                                <i class="fas fa-star"></i>
                            </label>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem;">
            <button type="submit" style="flex: 1; background: linear-gradient(135deg, #0d9488, #0d9488); color: white; border: none; padding: 1rem; border-radius: 0.5rem; font-weight: 700; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(13, 148, 136, 0.3)'" onmouseout="this.style.boxShadow='none'">
                <i class="fas fa-check me-2"></i>Submit Review
            </button>
            <a href="{{ route('offers.show', $offer) }}" style="flex: 1; background: #ecf0f1; color: #2c3e50; border: none; padding: 1rem; border-radius: 0.5rem; font-weight: 700; cursor: pointer; text-decoration: none; text-align: center; transition: all 0.2s ease;">
                <i class="fas fa-times me-2"></i>Cancel
            </a>
        </div>
    </form>
</div>

<script>
    let selectedRating = 0;

    function highlightStars(rating) {
        const buttons = document.querySelectorAll('.rating-btn');
        buttons.forEach((btn, index) => {
            if (index < rating) {
                btn.style.color = '#f39c12';
            } else {
                btn.style.color = '#bdc3c7';
            }
        });
    }

    function resetStars() {
        const buttons = document.querySelectorAll('.rating-btn');
        buttons.forEach((btn, index) => {
            if (index < selectedRating) {
                btn.style.color = '#f39c12';
            } else {
                btn.style.color = '#bdc3c7';
            }
        });
    }

    document.querySelectorAll('.rating-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            document.getElementById('rating').value = selectedRating;
            resetStars();
        });
    });

    function updateStarColor(element, name) {
        const parent = element.closest('div:has(input[type="radio"])');
        parent.querySelectorAll('label').forEach((label, index) => {
            const input = label.querySelector('input[type="radio"]');
            if (input && input.checked) {
                label.style.color = ['#f39c12', '#3498db', '#27ae60', '#9b59b6', '#e67e22', '#e74c3c'][index % 6];
            } else if (!input.checked) {
                label.style.color = '#bdc3c7';
            }
        });
    }

    // Character counter
    document.querySelector('textarea[name="comment"]').addEventListener('input', function() {
        const maxLength = this.getAttribute('maxlength');
        const currentLength = this.value.length;
        this.nextElementSibling.textContent = `${currentLength}/${maxLength} characters`;
    });
</script>
@endsection
