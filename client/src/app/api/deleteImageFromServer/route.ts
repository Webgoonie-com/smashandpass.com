import { unlink } from 'fs/promises';
import { join } from 'path';
import { NextRequest, NextResponse } from 'next/server';

async function handler(request: NextRequest) {
    try {
        const { imageData } = await request.json();
        

        if(!imageData)  return NextResponse.json({ Error: false, message: 'File Empty' });

         // Ensure imageData is an object and has a property 'local'
        const localPath = imageData && imageData.local;
        
        if (!localPath) {
            return NextResponse.json({ success: false, message: 'Local path not provided' });
        }

        // Delete the file from the file system
        await unlink(localPath);

        return NextResponse.json({ success: true, message: 'File deleted successfully' });
    } catch (error) {
        console.error('Error deleting file:', error);
        return NextResponse.json({ success: false, message: 'Error deleting file', error: error });
    }
}


export { handler as GET, handler as POST }