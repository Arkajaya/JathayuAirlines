<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->reactive()->maxLength(255),
                Toggle::make('is_published')->required(),
                Textarea::make('excerpt')->columnSpanFull()->maxLength(500),
                MarkdownEditor::make('content')->required()->columnSpanFull()->minHeight('300px'),
                TextInput::make('author')->required()->maxLength(255),
                FileUpload::make('featured_image')->image()->disk('public')->nullable(),
            ]);
    }
}
