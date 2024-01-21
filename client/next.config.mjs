/** @type {import('next').NextConfig} */
const nextConfig = {
    reactStrictMode: true,
    swcMinify: true,
    webpack(config) {
        config.resolve.fallback = {
          ...config.resolve.fallback,
          fs: false,
        };
        
        //  config.infrastructureLogging = { debug: /PackFileCache/ };
      
        //  let modularizeImports = null;
        // config.module.rules.some((rule) =>
        //   rule.oneOf?.some((oneOf) => {
        //     modularizeImports =
        //       oneOf?.use?.options?.nextConfig?.modularizeImports;
        //     return modularizeImports;
        //   }),
        // );
            
        return config;
      },
      images: {
        domains: [
          'res.cloudinary.com', 
          'avatars.githubusercontent.com',
          'lh3.googleusercontent.com'
        ],
        remotePatterns: [
          {
            protocol: "https",
            hostname: "tailwindui.com",
          },
          {
            protocol: "https",
            hostname: "images.unsplash.com",
          },
          {
            protocol: "https",
            hostname: "uko-react.vercel.app",
          },
          {
            protocol: "http",
            hostname: "localhost",
          },
          {
            protocol: "https",
            hostname: "localhost",
          },
          {
            protocol: "http",
            hostname: "localhost:7667",
          },
          {
            protocol: "https",
            hostname: "smashandpass.com",
          },
          {
            protocol: "https",
            hostname: "api.smashandpass.com",
          },
          {
            protocol: "https",
            hostname: "avatars.githubusercontent.com",
          },
        ],
      },
};

export default nextConfig;
