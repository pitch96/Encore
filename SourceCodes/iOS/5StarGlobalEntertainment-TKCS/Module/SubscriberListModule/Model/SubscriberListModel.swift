//
//  SubscriberListModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import Foundation
// MARK: - Subscriber list Model
struct SubscriberListModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: [SubscriberData]?
}

// MARK: - SubscriberData
struct SubscriberData: Codable {
    var id: Int?
    var email: String?
    var status: Int?
    var createdAt, updatedAt: String?

    enum CodingKeys: String, CodingKey {
        case id, email, status
        case createdAt = "created_at"
        case updatedAt = "updated_at"
    }
}
