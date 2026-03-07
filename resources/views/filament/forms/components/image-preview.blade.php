<div>
    @if($imagePath)
        <div class="space-y-2">
            <img 
                src="{{ asset('storage/' . $imagePath) }}" 
                alt="Current Image"
                style="{{ $imageStyle ?? 'max-height: 192px;' }}; display: block; margin-left: auto; margin-right: auto;"
                class="rounded-lg border border-gray-300 dark:border-gray-600 {{ $objectFit ?? 'object-contain' }}"
            />
        </div>
    @else
        <div class="text-sm text-gray-500 dark:text-gray-400">
            No image uploaded yet.
        </div>
    @endif
</div>
