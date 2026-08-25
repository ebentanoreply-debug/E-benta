@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <ul class="pagination" style="gap: 0.35rem; margin: 0; display: flex; flex-wrap: wrap; justify-content: center;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" style="margin: 0;">
                    <span class="page-link" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: #cbd5e1; border: 1px solid rgba(59, 130, 246, 0.12); border-radius: 0.5rem; background: #f8fafc; cursor: not-allowed; opacity: 0.65; display: inline-flex; align-items: center; justify-content: center; line-height: 1.4;">
                        <i class="fas fa-chevron-left" style="margin-right: 0.5rem;"></i>Previous
                    </span>
                </li>
            @else
                <li class="page-item" style="margin: 0;">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 0.5rem; background: white; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; line-height: 1.4; transition: all 0.2s ease; cursor: pointer;" onmouseover="this.style.background='rgba(59, 130, 246, 0.08)'; this.style.color='#2563eb'; this.style.borderColor='rgba(59, 130, 246, 0.4)';" onmouseout="this.style.background='white'; this.style.color='#3b82f6'; this.style.borderColor='rgba(59, 130, 246, 0.25)';">
                        <i class="fas fa-chevron-left" style="margin-right: 0.5rem;"></i>Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" style="margin: 0;">
                        <span class="page-link" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: #cbd5e1; border: 1px solid rgba(59, 130, 246, 0.12); border-radius: 0.5rem; background: white; display: inline-flex; align-items: center; justify-content: center; line-height: 1.4;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" style="margin: 0;">
                                <span class="page-link" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: white; border: 1px solid #3b82f6; border-radius: 0.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); display: inline-flex; align-items: center; justify-content: center; line-height: 1.4; box-shadow: 0 2px 6px rgba(59, 130, 246, 0.2); min-width: 2rem;">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item" style="margin: 0;">
                                <a class="page-link" href="{{ $url }}" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 0.5rem; background: white; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; line-height: 1.4; transition: all 0.2s ease; cursor: pointer; min-width: 2rem;" onmouseover="this.style.background='rgba(59, 130, 246, 0.08)'; this.style.color='#2563eb'; this.style.borderColor='rgba(59, 130, 246, 0.4)';" onmouseout="this.style.background='white'; this.style.color='#3b82f6'; this.style.borderColor='rgba(59, 130, 246, 0.25)';">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item" style="margin: 0;">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 0.5rem; background: white; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; line-height: 1.4; transition: all 0.2s ease; cursor: pointer;" onmouseover="this.style.background='rgba(59, 130, 246, 0.08)'; this.style.color='#2563eb'; this.style.borderColor='rgba(59, 130, 246, 0.4)';" onmouseout="this.style.background='white'; this.style.color='#3b82f6'; this.style.borderColor='rgba(59, 130, 246, 0.25)';">
                        Next<i class="fas fa-chevron-right" style="margin-left: 0.5rem;"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" style="margin: 0;">
                    <span class="page-link" style="padding: 0.5rem 0.8rem; font-size: 0.9rem; color: #cbd5e1; border: 1px solid rgba(59, 130, 246, 0.12); border-radius: 0.5rem; background: #f8fafc; cursor: not-allowed; opacity: 0.65; display: inline-flex; align-items: center; justify-content: center; line-height: 1.4;">
                        Next<i class="fas fa-chevron-right" style="margin-left: 0.5rem;"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
