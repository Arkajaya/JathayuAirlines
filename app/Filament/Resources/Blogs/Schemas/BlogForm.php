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
                TextInput::make('title')->required()->reactive(),
                Toggle::make('is_published')->required(),
                Textarea::make('excerpt')->columnSpanFull(),
                MarkdownEditor::make('content')->required()->columnSpanFull()->minHeight('300px'),
                TextInput::make('author')->required(),
                FileUpload::make('featured_image')->image()->nullable(),
            ]);
    }
}
