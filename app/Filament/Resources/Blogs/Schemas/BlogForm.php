<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required()->reactive(),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated(false)
                    ->hint('Auto-generated from the title; leave blank to generate'),
                Textarea::make('excerpt')->columnSpanFull(),
                RichEditor::make('content')->required()->columnSpanFull(),
                TextInput::make('author')->required(),
                FileUpload::make('featured_image')->image()->nullable(),
                TextInput::make('views')->numeric()->default(0),
                Toggle::make('is_published')->required(),
            ]);
    }
}
