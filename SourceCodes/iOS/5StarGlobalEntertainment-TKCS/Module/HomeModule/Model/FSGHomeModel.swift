//
//  FSGHomeModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 05/12/22.
//

import Foundation

// MARK: - Home Page Model
struct HomePage: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: DataClass?
}

// MARK: - Home Page Details
struct DataClass: Codable {
    var events: [Event]?
    var categories: [Category]?
    var bannerImages: [BannerImage]?
    var popularEvents: [Event]?

    enum CodingKeys: String, CodingKey {
        case events, categories
        case bannerImages = "banner_images"
        case popularEvents = "popular_events"
    }
}

// MARK: - BannerImage
struct BannerImage: Codable {
    var id: Int?
    var description: String?
    var bannerImage: String?
    var status: Int?
    var deletedAt: String?
    var createdAt: String?
    var updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, description
        case bannerImage = "banner_image"
        case status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - Category
struct Category: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - Event
struct Event: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime: String?
    var image: String?
    var description: String?
    var status, verifiedPromoterEvent, isPopular: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status, verifiedPromoterEvent, isPopular
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
// MARK: - Home Page Category
struct HomePageCategoryData: Codable {
    let statusCode: Int?
    let success: Bool?
    let message: String?
    var data: [Category]?
}
// MARK: - Subscriber model
struct SubscribeModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
}
// MARK: - CartModelData
struct CategorySearch: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [CategorySearchData]?
}

// MARK: - Datum
struct CategorySearchData: Codable {
    var id, userID: Int?
    var eventTitle: String?
    var categoryID: Int?
    var organizer, venue, address, city: String?
    var zipcode, startDate, endDate, startTime: String?
    var endTime: String?
    var image: String?
    var description: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case eventTitle = "event_title"
        case categoryID = "category_id"
        case organizer, venue, address, city, zipcode
        case startDate = "start_date"
        case endDate = "end_date"
        case startTime = "start_time"
        case endTime = "end_time"
        case image, description, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}

// MARK: - Category list Model
struct CategoryList: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [CategoryListData]?
}

// MARK: - Category list Model Details
struct CategoryListData: Codable {
    var id, userID: Int?
    var name: String?
    var status: Int?
    var deletedAt: String?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id
        case userID = "user_id"
        case name, status
        case deletedAt = "deleted_at"
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
