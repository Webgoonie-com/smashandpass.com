/** @type {import('next').NextConfig} */
const nextConfig = {
    reactStrictMode: true,
    swcMinify: true,
    webpack(config) {
        config.resolve.fallback = {
          ...config.resolve.fallback,
          fs: false,
        };
        
        config.infrastructureLogging = { debug: /PackFileCache/ };
      
        let modularizeImports = null;
        config.module.rules.some((rule) =>
          rule.oneOf?.some((oneOf) => {
            modularizeImports =
              oneOf?.use?.options?.nextConfig?.modularizeImports;
            return modularizeImports;
          }),
        );
            
        return config;
      },
      images: {
        domains: [
          "ui.shadcn.com",
          "avatars.githubusercontent.com",
          "lh3.googleusercontent.com",
          "images.unsplash.com"
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
            protocol: "http",
            hostname: "localhost:3333",
          },
          {
            protocol: "http",
            hostname: "localhost:3334",
          },
        ],
      },
};

export default nextConfig;
