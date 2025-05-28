export const LoadingSkeleton = ({ className = "" }) => (
  <div className={`animate-pulse bg-gray-200 rounded ${className}`}></div>
)

export const ProductCardSkeleton = () => (
  <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <LoadingSkeleton className="h-48 w-full" />
    <div className="p-4 space-y-3">
      <LoadingSkeleton className="h-4 w-3/4" />
      <LoadingSkeleton className="h-3 w-1/2" />
      <LoadingSkeleton className="h-6 w-1/3" />
      <LoadingSkeleton className="h-10 w-full" />
    </div>
  </div>
)
