/// <reference types="vite/client" />
 
interface ImportMetaEnv {
    readonly VITE_APP_API_URL: string
    // add other environment variables here as needed
  }
  
  interface ImportMeta {
    readonly env: ImportMetaEnv
  }