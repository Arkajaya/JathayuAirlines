<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->reactive(),
                Toggle::make('is_published')->required(),
                DateTimePicker::make('published_at')
                    ->label('Publish Time')
                    ->helperText('Set scheduled publish time (must be now or in the future)')
                    ->rules(['after_or_equal:now'])
                    ->nullable(),
                Textarea::make('excerpt')->columnSpanFull(),
                MarkdownEditor::make('content')->required()->columnSpanFull()->minHeight('300px'),
                TextInput::make('author')->required(),
                FileUpload::make('featured_image')->image()->disk('public')->nullable(),
            ]);
    }
}
