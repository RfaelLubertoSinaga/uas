<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Produk Management';
    protected static ?string $navigationLabel = 'Produk Sepatu';
    protected static ?string $modelLabel = 'Produk Sepatu';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),

                Forms\Components\TextInput::make('merek')
                    ->required()
                    ->maxLength(50),

                Forms\Components\TextInput::make('ukuran')
                    ->required()
                    ->maxLength(10),

                Forms\Components\TextInput::make('warna')
                    ->maxLength(30),

                Forms\Components\TextInput::make('harga')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('stok')
                    ->numeric()
                    ->required(),

                Forms\Components\Textarea::make('deskripsi')
                    ->rows(3),

                Forms\Components\FileUpload::make('gambar')
                    ->image()
                    ->directory('produk')
                    ->imagePreviewHeight('150')
                    ->maxSize(2048),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')->label('Foto')->circular(),
                Tables\Columns\TextColumn::make('nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('merek')->sortable(),
                Tables\Columns\TextColumn::make('ukuran'),
                Tables\Columns\TextColumn::make('harga')->money('IDR'),
                Tables\Columns\TextColumn::make('stok'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
