<?php

namespace App\Observers;

use App\Models\Institution;
use Illuminate\Support\Facades\Storage;

class InstitutionObserver
{
    public function updating(Institution $institution): void
    {
        $this->deleteOldImageIfChanged($institution, 'logo');
        $this->deleteOldImageIfChanged($institution, 'favicon');
    }

    public function deleting(Institution $institution): void
    {
        $this->deleteImageIfExists($institution->logo);
        $this->deleteImageIfExists($institution->favicon);
    }

    private function deleteOldImageIfChanged(Institution $institution, string $field): void
    {
        if ($institution->isDirty($field)) {
            $oldImage = $institution->getOriginal($field);
            $this->deleteImageIfExists($oldImage);
        }
    }

    private function deleteImageIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
